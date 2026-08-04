FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY admin/ .

RUN cp .env.example .env

RUN composer install --no-dev --no-interaction --prefer-dist

RUN php artisan key:generate --force

RUN php artisan migrate --force \
    && php artisan db:seed --force

RUN mkdir -p storage/app/public \
    storage/framework/views \
    storage/framework/sessions \
    storage/framework/cache/data \
    storage/framework/cache/lock-files \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

COPY apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
