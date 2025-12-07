# 1. Usamos PHP 8.2 con Apache integrado (Imagen oficial)
FROM php:8.2-apache

# 2. Instalamos dependencias del sistema y extensiones necesarias
# Agregamos 'git' y 'curl' y 'unzip' que son vitales para Composer
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql zip

# 3. Activamos mod_rewrite de Apache (Vital para las rutas de Laravel)
RUN a2enmod rewrite

# 4. INSTALACIÓN MANUAL DE COMPOSER (El arreglo del error)
# Descargamos el archivo directamente en lugar de usar la imagen de Docker Hub
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# 5. Configuramos la carpeta de trabajo
WORKDIR /var/www/html

# 6. Copiamos todos tus archivos al servidor
COPY . .

# 7. Instalamos las librerías de Laravel
RUN composer install --no-dev --optimize-autoloader

# 8. Damos permisos de escritura a las carpetas de logs y cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Configuramos Apache para que apunte a la carpeta 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 10. Exponemos el puerto 80
EXPOSE 80

# 11. COMANDO DE ARRANQUE:
# - Borra y crea la base de datos (--seed)
# - Vincula las imágenes (storage:link)
# - Inicia el servidor Apache
CMD php artisan migrate:fresh --seed --force && php artisan storage:link && apache2-foreground

# Comentario para forzar actualización en Git: Versión Final Railway v2