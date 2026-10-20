#!/bin/sh
set -e

# Render memberi variabel PORT; Apache harus mendengarkan port tersebut.
PORT="${PORT:-80}"
sed -ri "s/VirtualHost \*:80/VirtualHost *:${PORT}/" /etc/apache2/sites-available/000-default.conf
sed -ri "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# Migrasi idempoten. Bila database belum siap, container tetap jalan agar
# log dapat diperiksa lewat dashboard Render.
php artisan migrate --force || echo "PERINGATAN: migrasi gagal, periksa variabel DB_*."

# Hanya berguna untuk disk lokal; untuk R2/S3 perintah ini dilewati.
php artisan storage:link >/dev/null 2>&1 || true

exec apache2-foreground
