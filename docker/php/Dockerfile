FROM php:8.3-fpm

LABEL maintainer="Juan Blariza"

ARG path=/var/www/curotec

# INSTALL DEPENDENCIES
RUN apt-get update && apt-get install -y \
    openssl \
    build-essential \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    locales \
    apt-transport-https \
    wget \
    lsb-release \
    libxml2-dev \
    ca-certificates \
    git \
    nano \
    libonig-dev \
    supervisor \
    zip \
    libpq-dev

# PGSQL
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# CONFIGURE PHP EXTENSIONS
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# LIBRARIES REQUIRED FOR LARAVEL (sin MySQL)
RUN docker-php-ext-install \
    bcmath \
    ctype \
    fileinfo \
    iconv \
    gd \
    mbstring \
    xml \
    pcntl

# INSTALL COMPOSER
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# PHP ERROR LOG FILES
RUN mkdir /var/log/php && \
    touch /var/log/php/errors.log &&  \
    touch /var/log/php/access.log &&  \
    chmod 775 /var/log/php/errors.log

# QUEUE ERROR LOG FILES
RUN mkdir /var/log/curotec && \
    touch /var/log/curotec/worker.log &&  \
    chmod 775 /var/log/curotec/worker.log

# APP FILES
COPY ./ $path

WORKDIR $path

RUN chmod -R 755 storage bootstrap/cache

RUN chown -R www-data:www-data ./
RUN chgrp -R www-data storage bootstrap/cache
RUN chmod -R ug+rwx storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
