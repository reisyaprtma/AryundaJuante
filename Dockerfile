# Stage 1: PHP dependencies and Composer
FROM php:8.2-cli AS php-builder

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y git unzip libzip-dev curl \
    && docker-php-ext-install pdo_mysql zip

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
# Copy only composer files to leverage Docker cache
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Stage 2: Build frontend assets
FROM node:20 AS js-builder
WORKDIR /app
# Copy package files and install dependencies
COPY package*.json ./
RUN npm install
# Copy rest of source and build
COPY . .
RUN npm run build

# Stage 3: Final runtime image
FROM php:8.2-cli

# Install runtime dependencies
RUN apt-get update \
    && apt-get install -y libzip-dev unzip curl \
    && docker-php-ext-install pdo_mysql zip

# Copy Composer + vendor from builder
COPY --from=php-builder /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY --from=php-builder /app /app

# Copy built frontend assets
COPY --from=js-builder /app/public/js /app/public/js
COPY --from=js-builder /app/public/css /app/public/css

# Copy the rest of the application
COPY . .

# Setup application: generate key, migrate, cache
RUN php artisan key:generate \
    && php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose HTTP port
ENV PORT 10000
EXPOSE 10000

# Start the application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
