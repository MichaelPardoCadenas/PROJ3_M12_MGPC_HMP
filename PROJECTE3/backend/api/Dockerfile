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

# Copia archivos del proyecto al contenedor
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Instala dependencias con Composer
RUN composer install

# Establece permisos
RUN chown -R www-data:www-data /var/www/html

# Copia .htaccess si existe
COPY .htaccess /var/www/html/.htaccess

# Expone el puerto 80
EXPOSE 80
