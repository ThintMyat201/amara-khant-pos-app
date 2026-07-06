# Run these commands to fix POS (copy-paste in terminal on server)

Run these **on your server** in a terminal (SSH or local). Run as **root** or with **sudo**:

```bash
# 1. Ensure MySQL is running
systemctl start mysql
systemctl enable mysql

# 2. Find the actual project folder (in case it has a space in the name)
POSDIR=$(find /root -maxdepth 1 -type d -name "POS*" 2>/dev/null | head -1)
echo "Project at: $POSDIR"
ls "$POSDIR/artisan" || { echo "ERROR: artisan not found"; exit 1; }

# 3. If project has a different path (e.g. trailing space), symlink so service can use /root/POS_PROJECT
if [ -n "$POSDIR" ] && [ "$POSDIR" != "/root/POS_PROJECT" ]; then
  rm -f /root/POS_PROJECT
  ln -sfn "$POSDIR" /root/POS_PROJECT
  echo "Linked /root/POS_PROJECT -> $POSDIR"
fi

# 4. Reload and start POS
systemctl daemon-reload
systemctl restart pos-system

# 5. Wait and check
sleep 4
systemctl status pos-system
ss -tlnp | grep 8000

# 6. Test (should print 200)
curl -s -o /dev/null -w "HTTP %{http_code}\n" http://127.0.0.1:8000/
```

If step 6 shows **HTTP 200**, open **http://156.67.30.58:8000** in your browser.

If the service fails, run and share the output:
```bash
journalctl -u pos-system -n 60 --no-pager
```
