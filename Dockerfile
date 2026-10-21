
FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libonig-dev \
    curl nodejs npm \
    && docker-php-ext-install pdo_pgsql mbstring zip \
    && a2enmod rewrite headers \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

RUN npm install && npm run build

RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
