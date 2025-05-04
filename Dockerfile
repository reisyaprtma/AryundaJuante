# 1. Base image dengan PHP 8.2 CLI
FROM php:8.2-cli

# 2. Install extensions & tools yang dibutuhkan
RUN apt-get update && \
    apt-get install -y git unzip libzip-dev && \
    docker-php-ext-install pdo_mysql zip

# 3. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Copy source code
WORKDIR /app
COPY . .

# 5. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 6. Build assets (jika pakai npm/vite)
RUN apt-get install -y curl && \
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install && npm run build

# 7. Expose port & jalankan
ENV PORT 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
