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

# Habilita mod_rewrite y permite .htaccess
RUN a2enmod rewrite \
    && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copia todo el contenido del proyecto
COPY . /var/www/html

# Ejecuta composer en la carpeta de la API
WORKDIR /var/www/html/backend/api
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Vuelve al root de la web
WORKDIR /var/www/html

# Copia el .htaccess de redirección en la raíz
RUN printf 'DirectoryIndex frontend/register.html\n\n<IfModule mod_rewrite.c>\n  RewriteEngine On\n  RewriteCond %%{REQUEST_URI} ^/$\n  RewriteRule ^$ /frontend/register.html [L]\n</IfModule>\n' \
    > /var/www/html/.htaccess

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
