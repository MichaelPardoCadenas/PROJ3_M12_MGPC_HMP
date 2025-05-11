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

# Copia todo el contenido del proyecto
COPY . /var/www/html

# Cambia el DocumentRoot para servir el frontend
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/frontend|' /etc/apache2/sites-available/000-default.conf

# Ejecuta composer en la carpeta donde está composer.json
WORKDIR /var/www/html/backend/api
RUN composer install

# Establece el directorio por defecto
WORKDIR /var/www/html

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
