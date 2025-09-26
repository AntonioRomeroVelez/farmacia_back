FROM php:8.2-apache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el proyecto
COPY . /var/www/html

# Configura Apache para servir desde /public
RUN echo "DocumentRoot /var/www/html/public" >> /etc/apache2/sites-available/000-default.conf


# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el proyecto
COPY . /var/www/html
WORKDIR /var/www/html

# Copia el .env si lo tienes en tu repo
# COPY .env.production .env

# Instala dependencias
RUN composer install --no-dev --optimize-autoloader || true


# Genera clave si no existe
RUN php artisan key:generate || true

# Cachea configuración
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# Ejecuta migraciones
RUN php artisan migrate --force || true

# Permisos
RUN chown -R www-data:www-data /var/www/html
