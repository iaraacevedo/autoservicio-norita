# 1. Usamos PHP 8.4 con Apache (Para que coincida con tu computadora)
FROM php:8.4-apache

# 2. Instalamos dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql zip

# 3. Activamos rutas amigables de Laravel
RUN a2enmod rewrite

# 4. Instalamos Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# 5. Configuramos directorio
WORKDIR /var/www/html

# 6. Copiamos los archivos
COPY . .

# 7. Instalamos las librerías
# Usamos --ignore-platform-reqs por si hay alguna mínima diferencia de versión, para que no falle
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 8. Permisos de carpetas
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Configuramos Apache (Corrección para que funcionen las rutas y .htaccess)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 10. Puerto 80
EXPOSE 80

# 11. Arranque
CMD php artisan migrate:fresh --seed --force && php artisan storage:link && apache2-foreground

# Actualización para forzar PHP 8.4