FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl ca-certificates gnupg \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath exif pcntl \
    && rm -rf /var/lib/apt/lists/*

# Vite 7 needs Node 20.19+ / 22.12+ — Debian apt nodejs is too old.
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts --no-autoloader

COPY . .
RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi || true

# Build Vite/Tailwind assets into public/build (manifest.json required in production)
RUN (npm ci || npm install) \
    && npm run build \
    && test -f public/build/manifest.json \
    && rm -rf node_modules

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chmod +x docker/entrypoint.sh

ENV PORT=8000
EXPOSE 8000

ENTRYPOINT ["sh", "/app/docker/entrypoint.sh"]
