#!/bin/bash
# Fix and start POS - run as root: sudo ./start-pos.sh
set -e
echo "Reloading systemd..."
systemctl daemon-reload
echo "Restarting pos-system..."
systemctl restart pos-system
sleep 2
if systemctl is-active --quiet pos-system; then
  echo "OK: POS is running. Open http://YOUR_SERVER_IP:8000"
  systemctl status pos-system --no-pager
else
  echo "FAIL: Service did not start. Logs:"
  journalctl -u pos-system -n 40 --no-pager
  exit 1
fi
