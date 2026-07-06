#!/bin/bash
OUT=/root/POS_PROJECT/status-check.txt
{
  echo "=== Status Check $(date) ==="
  echo "1. Service status:"
  systemctl is-active pos-system || echo "INACTIVE"
  echo ""
  echo "2. Port 8000:"
  ss -tlnp | grep 8000 || echo "Nothing on 8000"
  echo ""
  echo "3. Recent logs:"
  journalctl -u pos-system -n 10 --no-pager | tail -10
  echo ""
  echo "4. Test curl:"
  curl -s -o /dev/null -w "HTTP %{http_code}\n" http://127.0.0.1:8000/ || echo "curl failed"
  echo "=== End ==="
} > "$OUT" 2>&1
cat "$OUT"
