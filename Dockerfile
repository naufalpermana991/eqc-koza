# Gunakan image PHP 8.1 alpine yang ringan
FROM php:8.1-alpine

RUN set -ex && apk --no-cache add postgresql-dev jpeg-dev zlib-dev libpng-dev

# Instal ekstensi PHP yang diperlukan untuk Laravel
RUN docker-php-ext-install pdo pdo_pgsql bcmath exif pcntl gd intl zlib

# Instal Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Salin file composer.lock dan composer.json ke dalam container
COPY composer.lock composer.json /var/www/html/

# Install dependensi PHP menggunakan Composer
RUN composer install --no-scripts --no-autoloader

# Salin seluruh proyek Laravel ke dalam container
COPY . /var/www/html/

# Generate autoload files dan jalankan script aplikasi yang dibutuhkan
RUN composer dump-autoload --optimize && \
    php artisan route:cache && \
    php artisan config:cache

# Berikan izin tertentu kepada storage dan cache
RUN chmod -R 777 storage bootstrap/cache

# Expose port 80
EXPOSE 80

# Perintah untuk menjalankan aplikasi Laravel
CMD php artisan serve --host=0.0.0.0 --port=80
