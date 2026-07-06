#!/bin/bash

# POS System Deployment Script
# This script automates the deployment process for production

set -e  # Exit on error

echo "🚀 Starting POS System Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root or with sudo${NC}"
    exit 1
fi

PROJECT_DIR="/root/POS_PROJECT"
SERVICE_NAME="pos-system"
SERVICE_FILE="/etc/systemd/system/${SERVICE_NAME}.service"

# Step 1: Navigate to project directory
cd "$PROJECT_DIR" || exit

echo -e "${GREEN}✓${NC} Project directory: $PROJECT_DIR"

# Step 2: Install PHP dependencies
echo -e "${YELLOW}Installing PHP dependencies...${NC}"
composer install --no-dev --optimize-autoloader

# Step 3: Install Node dependencies and build
echo -e "${YELLOW}Installing Node dependencies...${NC}"
npm install

echo -e "${YELLOW}Building production assets...${NC}"
npm run build

# Step 4: Set permissions
echo -e "${YELLOW}Setting permissions...${NC}"
chown -R www-data:www-data "$PROJECT_DIR"
chmod -R 755 "$PROJECT_DIR"
chmod -R 775 "$PROJECT_DIR/storage"
chmod -R 775 "$PROJECT_DIR/bootstrap/cache"

# Step 5: Optimize Laravel
echo -e "${YELLOW}Optimizing Laravel...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 6: Create systemd service
echo -e "${YELLOW}Creating systemd service...${NC}"
cat > "$SERVICE_FILE" << EOF
[Unit]
Description=POS System Laravel Application
After=network.target mysql.service

[Service]
Type=simple
User=www-data
Group=www-data
WorkingDirectory=$PROJECT_DIR
ExecStart=/usr/bin/php artisan serve --host=0.0.0.0 --port=8000
Restart=always
RestartSec=10
StandardOutput=syslog
StandardError=syslog
SyslogIdentifier=$SERVICE_NAME

[Install]
WantedBy=multi-user.target
EOF

# Step 7: Enable and start service
echo -e "${YELLOW}Enabling and starting service...${NC}"
systemctl daemon-reload
systemctl enable "$SERVICE_NAME"
systemctl restart "$SERVICE_NAME"

# Step 8: Check status
sleep 2
if systemctl is-active --quiet "$SERVICE_NAME"; then
    echo -e "${GREEN}✓${NC} Service is running!"
    echo -e "${GREEN}✓${NC} Service status:"
    systemctl status "$SERVICE_NAME" --no-pager -l
else
    echo -e "${RED}✗${NC} Service failed to start. Check logs:"
    journalctl -u "$SERVICE_NAME" -n 20 --no-pager
    exit 1
fi

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}🎊 Deployment Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "Useful commands:"
echo "  Start:   sudo systemctl start $SERVICE_NAME"
echo "  Stop:    sudo systemctl stop $SERVICE_NAME"
echo "  Restart: sudo systemctl restart $SERVICE_NAME"
echo "  Status:  sudo systemctl status $SERVICE_NAME"
echo "  Logs:    sudo journalctl -u $SERVICE_NAME -f"
echo ""
echo "Application should be running on: http://localhost:8000"
echo ""
