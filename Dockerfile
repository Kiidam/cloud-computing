FROM php:8.2-cli

# Instala dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev \
    libsqlite3-dev \
    sqlite3 \
    curl \
    gnupg \
    && docker-php-ext-install pdo pdo_sqlite zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Node.js y npm (para Laravel Mix/Vite si es necesario)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get update && apt-get install -y nodejs

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Crea el archivo de base de datos SQLite y ejecuta migraciones y seeders
RUN mkdir -p /app/database \
    && touch /app/database/database.sqlite \
    && php artisan migrate --seed --force

CMD php -S 0.0.0.0:10000 -t public public/index.php