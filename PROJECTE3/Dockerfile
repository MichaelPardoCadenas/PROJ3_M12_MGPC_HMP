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

# Copia todos los archivos del proyecto
COPY . /var/www/html

# Copia el .htaccess a la raíz del servidor
COPY .htaccess /var/www/html/.htaccess

# Ejecuta Composer en la carpeta API
WORKDIR /var/www/html/backend/api
RUN composer install

# Establece el directorio final
WORKDIR /var/www/html

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
