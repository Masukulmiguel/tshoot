FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo_pgsql pdo_sqlite \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY admin/ .

RUN mkdir -p bootstrap/cache \
    storage/app/public \
    storage/framework/views \
    storage/framework/sessions \
    storage/framework/cache/data \
    storage/framework/cache/lock-files \
    storage/logs \
    bootstrap/cache

RUN composer install --no-dev --no-interaction --prefer-dist

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

COPY apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
