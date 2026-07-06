#!/bin/bash
# Find project dir (where this script lives)
DIR="$(cd "$(dirname "$0")" && pwd)"
cd "$DIR" || exit 1
[ -f artisan ] || { echo "artisan not found in $DIR"; exit 1; }
exec /usr/bin/php artisan serve --host=0.0.0.0 --port=8000
