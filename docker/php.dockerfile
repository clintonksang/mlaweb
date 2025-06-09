FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
        git curl zip unzip libpng-dev libonig-dev libxml2-dev \
        libsqlite3-dev libgmp-dev sqlite3 npm && \
    docker-php-ext-install mbstring bcmath exif gd gmp pdo_mysql pdo_sqlite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY core /var/www/html/core

RUN cd core && composer install --no-dev --prefer-dist --no-interaction

CMD ["php-fpm", "-F"]
