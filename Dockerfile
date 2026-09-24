FROM php:7.4-apache

# PHP 7.4 images ship Debian 11. Current security mirrors 404, so use the archive.
RUN set -eux; \
    printf 'deb http://archive.debian.org/debian bullseye main\n' > /etc/apt/sources.list; \
    rm -f /etc/apt/sources.list.d/*.list; \
    echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        git \
        unzip \
        default-mysql-client \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libicu-dev; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        zip \
        gd \
        bcmath \
        exif \
        pcntl \
        intl \
        opcache; \
    a2enmod rewrite; \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

COPY docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY docker/import-db.sh /usr/local/bin/import-db.sh
RUN chmod +x /usr/local/bin/entrypoint.sh /usr/local/bin/import-db.sh

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-interaction --prefer-dist --no-dev --no-scripts --no-ansi

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
