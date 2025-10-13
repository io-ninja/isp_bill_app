#!/bin/bash
set -e

echo "========================================"
echo "🚀 Starting container services..."
echo "========================================"

# Jalankan Supervisor yang akan nge-manage Nginx + PHP-FPM
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
