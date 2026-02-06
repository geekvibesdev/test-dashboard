#!/bin/sh
set -e
cd /var/www/html
if [ -f "spark" ]; then
  php spark migrate --all 2>&1 || true
fi
exec apache2-foreground
