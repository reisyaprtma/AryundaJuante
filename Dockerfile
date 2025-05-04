# Stage 1: PHP dependencies and Composer
FROM php:8.2-cli AS php-builder

# Allow composer to run out of memory and as root
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y git unzip libzip-dev curl \
    && docker-php-ext-install pdo_mysql zip

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
# Copy composer files and install PHP deps
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Final runtime image
FROM php:8.2-cli

# Install runtime extensions
RUN apt-get update \
    && apt-get install -y libzip-dev unzip curl \
    && docker-php-ext-install pdo_mysql zip

WORKDIR /app
# Copy application with vendor from builder
COPY --from=php-builder /usr/bin/composer /usr/bin/composer
COPY --from=php-builder /app /app

# Copy application code and pre-built assets (ensured built locally)
COPY . .

# Setup application: generate key, run migrations, cache config/routes/views
RUN php artisan key:generate \
    && php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose HTTP port and start Laravel
ENV PORT 10000
EXPOSE 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
