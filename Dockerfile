# 1. Usamos PHP 8.4 (La versión moderna que tu código necesita)
FROM php:8.4-apache

# 2. Instalamos dependencias del sistema y extensiones PHP
# Agregamos 'git', 'curl' y 'unzip' para que Composer no falle
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql zip

# 3. Activamos el módulo "rewrite" de Apache (VITAL para las rutas de Laravel)
RUN a2enmod rewrite

# 4. Instalamos Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# 5. Configuramos la carpeta de trabajo
WORKDIR /var/www/html

# 6. Copiamos todos los archivos de tu proyecto al servidor
COPY . .

# 7. --- AQUÍ ESTÁ LA MAGIA ---
# Copiamos TU configuración de Apache personalizada al servidor.
# Esto reemplaza la configuración por defecto y activa "AllowOverride All"
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# 8. Instalamos las librerías de Laravel
# Usamos --ignore-platform-reqs para evitar errores tontos de versión
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 9. Damos permisos a las carpetas de almacenamiento
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Exponemos el puerto 80
EXPOSE 80

# 11. Comando de Arranque
# - Borra y crea la base de datos (--seed)
# - Vincula las imágenes (storage:link)
# - Prende el servidor
CMD php artisan migrate:fresh --seed --force || true && php artisan storage:link || true && apache2-foreground