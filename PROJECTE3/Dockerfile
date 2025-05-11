FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilita mod_rewrite
RUN a2enmod rewrite

# Copia todo el proyecto
COPY . /var/www/html/

# Establece el directorio de trabajo (puedes poner el backend/api si quieres que arranque desde ahí)
WORKDIR /var/www/html/backend/api

# Instala dependencias de Composer (usa el composer.json desde raíz)
RUN composer install --working-dir=/var/www/html

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

# Copia .htaccess si existe
COPY .htaccess /var/www/html/.htaccess

# Expone el puerto 80
EXPOSE 80
