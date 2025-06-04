FROM php:8.2-cli

# Instala dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

CMD php artisan serve --host=0.0.0.0 --port=10000
