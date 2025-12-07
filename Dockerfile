# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalamos dependencias del sistema y extensiones de PHP
# Agregamos 'curl' y 'git' que son vitales para descargar composer sin errores
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql zip

# Activamos el módulo rewrite de Apache para que funcionen las rutas de Laravel
RUN a2enmod rewrite

# --- CAMBIO IMPORTANTE ---
# Instalamos Composer MANUALMENTE usando curl.
# Esto evita el error de "failed to authorize" al intentar bajar la imagen de Docker Hub.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Configuramos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos todos tus archivos al servidor
COPY . .

# Instalamos las librerías de Laravel
# El flag --ignore-platform-reqs ayuda si hay discrepancias de versiones de PHP
RUN composer install --no-dev --optimize-autoloader

# Damos permisos a las carpetas de almacenamiento (Vital para que no de Error 500)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configuramos Apache para que apunte a la carpeta public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Exponemos el puerto 80
EXPOSE 80

# Comando final: Corre migraciones, seeders y levanta el servidor
CMD php artisan migrate:fresh --seed --force && php artisan storage:link && apache2-foreground