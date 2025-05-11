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

# Copia todo el contenido al contenedor
COPY . /var/www/html

# Cambia el DocumentRoot a frontend
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/frontend|' /etc/apache2/sites-available/000-default.conf

# Establece el directorio de trabajo para Composer
WORKDIR /var/www/html/api

# Instala dependencias PHP
RUN composer install

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto
EXPOSE 80
