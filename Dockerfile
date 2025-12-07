# 1. Usamos PHP 8.4 OBLIGATORIAMENTE (Esto soluciona tu error de versión)
FROM php:8.4-apache

# 2. Instalamos lo necesario para que Composer funcione
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql zip

# 3. Activamos las rutas de Laravel
RUN a2enmod rewrite

# 4. Instalamos Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# 5. Configuramos carpeta
WORKDIR /var/www/html

# 6. Copiamos archivos
COPY . .

# 7. Instalamos librerías (Ignorando chequeos de plataforma para evitar bloqueos tontos)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 8. Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Configuración Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 10. Puerto
EXPOSE 80

# 11. COMANDO DE ARRANQUE ROBUSTO
# Usamos "|| true" para que si la base de datos falla, el servidor prenda igual y podamos ver el error en pantalla
CMD php artisan migrate:fresh --seed --force || true && php artisan storage:link || true && apache2-foreground