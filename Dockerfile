# Etapa 1: Instalar dependencias con Composer
FROM composer:2.6 as composerstep
WORKDIR /app
COPY ./src /app
RUN composer install --no-dev --ignore-platform-reqs

# Etapa 3: Crear imagen para producción
FROM php:8.2-apache

#Install php extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions pdo pdo_pgsql imagick zip xml xsl gd redis sockets bcmath

# Copiar el código fuente de la aplicación
COPY ./src /var/www/html

# Copiar las dependencias resueltas por composer
COPY --from=composerstep /app/vendor /var/www/html/vendor

# Copiar php.ini personalizado
ADD docker/php.ini /usr/local/etc/php/php.ini

# Copiar un virtual host personalizado si es necesario
ADD docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Activar modulo que permite leer htaccess y hacer redireccionamientos
RUN a2enmod rewrite

WORKDIR /var/www/html
# Dar permisos adecuados

RUN cp .env.example .env

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage


# Habilitamos la liga blanda al storage
RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage \
    && chown -h www-data:www-data /var/www/html/public/storage

# Etapa 2: Ejecutar pruebas unitarias
#FROM php:8.2-cli as tester
#COPY --from=composer /app /app
#WORKDIR /app
#COPY . .
# Aquí puedes agregar comandos para preparar el entorno de pruebas, como migraciones de base de datos si son necesarias
# Ejemplo: RUN php artisan migrate
#RUN ./vendor/bin/phpunit