FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql intl \
    && pecl install redis && pecl install xdebug  \
    && docker-php-ext-enable redis && docker-php-ext-enable xdebug \

RUN echo -e "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite && service apache2 restart

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

COPY default.conf /etc/apache2/sites-enabled/000-default.conf

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
