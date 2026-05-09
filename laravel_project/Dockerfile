FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpng-dev libonig-dev libxml2-dev libzip-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring xml zip bcmath

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e "s!/var/www/html!$APACHE_DOCUMENT_ROOT!g" \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e "s!/var/www/!$APACHE_DOCUMENT_ROOT!g" \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]