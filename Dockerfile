FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY admin/ .

RUN cp .env.example .env

RUN composer install --no-dev --no-interaction --prefer-dist

RUN php artisan key:generate --force

RUN touch database/database.sqlite \
    && php artisan migrate --force

RUN mkdir -p storage/app/public \
    storage/framework/views \
    storage/framework/sessions \
    storage/framework/cache/data \
    storage/framework/cache/lock-files \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
