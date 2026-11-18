#!/bin/bash
set -e

echo "[*] Preparando aplicación Laravel en Render..."

# Crear base de datos SQLite si está configurada y no existe
if [ "$DB_CONNECTION" = "sqlite" ]; then
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
        chown www-data:www-data /var/www/html/database/database.sqlite
    fi
fi

# Generar enlace simbólico para imágenes
php artisan storage:link || true

# Ejecutar migraciones
php artisan migrate --force || true

# Optimizar para producción
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Configurar puerto dinamico de Apache para Render
PORT="${PORT:-80}"
sed -i "s/Listen .*/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:.*>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

echo "[*] Iniciando servidor web Apache en puerto ${PORT}..."
exec apache2-foreground
