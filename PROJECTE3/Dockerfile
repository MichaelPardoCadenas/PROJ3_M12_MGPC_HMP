FROM php:8.2-apache

# Instala dependencias necesarias
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
COPY . /var/www/html

# Ejecuta Composer si existe composer.json
WORKDIR /var/www/html/backend/api
RUN if [ -f composer.json ]; then composer install; fi

# Establece el directorio por defecto
WORKDIR /var/www/html

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
