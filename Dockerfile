FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-interaction
RUN cp .env.example .env
RUN php artisan key:generate
RUN php artisan migrate:fresh --seed