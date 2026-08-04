FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy admin files
COPY admin/ .

# Install PHP dependencies
RUN composer install --no-dev --no-interaction --prefer-dist

# Create database
RUN touch database/database.sqlite

# Generate app key
RUN php artisan key:generate || true

# Run migrations
RUN php artisan migrate --force || true

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
