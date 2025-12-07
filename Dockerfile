# 1. Usamos PHP 8.4 (La versión que tu código necesita)
FROM php:8.4-apache

# 2. Instalamos dependencias y extensiones
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql zip

# 3. Activamos el módulo Rewrite de Apache (VITAL para que funcionen los links)
RUN a2enmod rewrite

# 4. Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# 5. Configuramos carpeta de trabajo
WORKDIR /var/www/html

# 6. Copiamos archivos
COPY . .

# 7. Instalamos librerías
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 8. Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. CONFIGURACIÓN DE APACHE (AQUÍ ESTÁ LA MAGIA) 🪄
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Cambiamos la ruta raíz a /public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# ¡ESTA LÍNEA ARREGLA EL ERROR 404! 
# Permite que el archivo .htaccess de Laravel funcione
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 10. Puerto
EXPOSE 80

# 11. Arranque
CMD php artisan migrate:fresh --seed --force || true && php artisan storage:link || true && apache2-foreground