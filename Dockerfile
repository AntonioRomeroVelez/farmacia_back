FROM php:8.2-apache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el proyecto
COPY . /var/www/html

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura Apache para servir desde /public y habilita mod_rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && a2enmod rewrite


# Permisos
RUN chown -R www-data:www-data /var/www/html

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

# Comando final para iniciar Apache
CMD ["apache2-foreground"]




