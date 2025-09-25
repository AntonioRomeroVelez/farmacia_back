FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el código
COPY . /var/www/html

WORKDIR /var/www/html

# Instala dependencias
RUN composer install --no-dev --optimize-autoloader

# Configura Apache
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

EXPOSE 80
