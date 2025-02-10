FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql intl \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite && service apache2 restart

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --verbose

COPY default.conf /etc/apache2/sites-enabled/000-default.conf

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
CMD service apache2 start && php artisan serve --host=0.0.0.0 --port=8000
