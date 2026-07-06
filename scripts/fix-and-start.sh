#!/bin/bash
# Run as root to fix and start POS
set -e
LOG=/tmp/pos-fix.log
exec > "$LOG" 2>&1

echo "=== Fix and start POS ==="
date

echo "1. Project check..."
ls -la /root/POS_PROJECT/artisan || { echo "ERROR: No artisan"; exit 1; }

echo "2. MySQL..."
systemctl start mysql 2>/dev/null || true
systemctl is-active mysql || echo "WARN: MySQL not active"

echo "3. Stop any existing process on 8000..."
fuser -k 8000/tcp 2>/dev/null || true
sleep 1

echo "4. Systemd daemon-reload and restart pos-system..."
systemctl daemon-reload
systemctl restart pos-system
sleep 3

echo "5. Status..."
systemctl status pos-system || true
echo "---"
ss -tlnp | grep 8000 || echo "Nothing on 8000"

echo "6. Test curl..."
curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/ || echo "curl failed"

echo "=== Done ==="
cp /tmp/pos-fix.log /root/POS_PROJECT/pos-fix.log 2>/dev/null || true
