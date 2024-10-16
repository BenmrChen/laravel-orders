FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libcurl4-openssl-dev \
    libssl-dev \
    brotli \
    libbrotli-dev \
    && docker-php-ext-install curl

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install swoole && docker-php-ext-enable swoole

WORKDIR /var/www

COPY . /var/www

RUN composer install

RUN php artisan optimize
RUN chmod -R 777 /var/www/storage

EXPOSE 80

CMD ["php", "artisan", "swoole:http:start"]

COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
