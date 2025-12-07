# 1. Usamos PHP 8.4
FROM php:8.4-apache

# 2. Instalamos dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql zip

# 3. Activamos Rewrite
RUN a2enmod rewrite

# 4. Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# 5. Configuramos carpeta
WORKDIR /var/www/html

# 6. Copiamos archivos
COPY . .

# 7. --- MAGIA: CREAMOS LA CONFIGURACIÓN DE APACHE AQUÍ MISMO ---
# Esto elimina la necesidad de subir el archivo 000-default.conf aparte
RUN echo '<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# 8. Instalamos librerías
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 9. Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Puerto
EXPOSE 80


CMD php artisan migrate --force || true && php artisan storage:link || true && apache2-foreground