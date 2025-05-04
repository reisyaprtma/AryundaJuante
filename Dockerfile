# Stage 1: PHP dependencies and Composer
FROM php:8.2-cli AS php-builder

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Copy Composer binary and install PHP deps
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Final runtime image
FROM php:8.2-cli

# Install runtime extensions
RUN apt-get update \
    && apt-get install -y libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

# Copy Composer and vendor from builder
COPY --from=php-builder /usr/bin/composer /usr/bin/composer
COPY --from=php-builder /app /app
WORKDIR /app

# Copy application code and pre-built assets (ensure you've run `npm run build` locally)
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
