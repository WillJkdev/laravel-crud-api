# Usar PHP 8.4 FPM como base
FROM php:8.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo en /var/www
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . . 

# Crear el archivo .env desde .env.local
RUN cp .env.local .env || true

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Asignar permisos a la carpeta storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Generar clave de aplicación
RUN php artisan key:generate

# Cachear configuración, rutas y vistas
RUN php artisan config:cache && php artisan route:cache

# Comando por defecto
CMD ["php-fpm"]
