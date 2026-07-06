#!/bin/bash
# All output to project file so we can read it
OUT="$(dirname "$0")/result.txt"
{
  echo "=== $(date) ==="
  systemctl daemon-reload && echo "daemon-reload OK" || echo "daemon-reload FAIL"
  systemctl stop pos-system 2>/dev/null; sleep 1
  systemctl start pos-system && echo "start OK" || echo "start FAIL"
  sleep 4
  systemctl is-active pos-system && echo "ACTIVE" || echo "INACTIVE"
  ss -tlnp 2>/dev/null | grep 8000 || echo "Port 8000: nothing"
  echo "=== end ==="
} > "$OUT" 2>&1
