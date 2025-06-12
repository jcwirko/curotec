FROM php:8.3-fpm

LABEL maintainer="Juan Blariza"

ARG path=/var/www/curotec/

#INSTALL DEPENDENCIES
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
    zip

#PGSQL
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

#REDIS
RUN pecl install -o -f redis \
        &&  rm -rf /tmp/pear \
        &&  docker-php-ext-enable redis

# Configure php extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

#Libraries required for Laravel
RUN docker-php-ext-install \
    pdo_mysql \
    bcmath \
    ctype \
    fileinfo \
    iconv \
    gd \
    mbstring \
    pdo_mysql \
    xml \
    pcntl

# Install composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# PHP Error Log Files
RUN mkdir /var/log/php && \
    touch /var/log/php/errors.log &&  \
    touch /var/log/php/access.log &&  \
    chmod 775 /var/log/php/errors.log

# Queue Error log files
RUN mkdir /var/log/curotec && \
    touch /var/log/curotec/worker.log &&  \
    chmod 775 /var/log/curotec/worker.log


COPY ./ $path

WORKDIR $path

RUN chmod -R 755 storage bootstrap/cache

RUN chown -R $USER:www-data ./
RUN chgrp -R www-data storage bootstrap/cache
RUN chmod -R ug+rwx storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
