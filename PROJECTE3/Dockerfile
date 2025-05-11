FROM php:8.2-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Habilita mod_rewrite
RUN a2enmod rewrite

# Copia el contenido del proyecto
COPY . /var/www/html

# Establece DocumentRoot en backend/api
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/backend/api|' /etc/apache2/sites-available/000-default.conf

# Establece directorio de trabajo
WORKDIR /var/www/html/backend/api

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ejecuta composer install
RUN composer install

# Asigna permisos
RUN chown -R www-data:www-data /var/www/html

# Copia .htaccess si existe
COPY backend/api/.htaccess /var/www/html/backend/api/.htaccess

EXPOSE 80
