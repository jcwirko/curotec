FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    linux-headers \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libpng-dev \
    curl-dev \
    icu-dev \
    libxml2-dev \
    git \
    libzip-dev \
    fcgi \
    bash \
    postgresql-client \
    postgresql-dev \
    nodejs \
    npm

RUN docker-php-ext-configure gd --with-jpeg --with-webp

RUN docker-php-ext-install \
    curl \
    intl \
    gd \
    pdo \
    pdo_pgsql \
    pgsql \
    simplexml \
    xml \
    soap \
    bcmath \
    pcntl \
    zip

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

RUN pecl install redis && \
    docker-php-ext-enable redis

## Composer
RUN php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");' > expected_checksum && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "echo hash_file('sha384', 'composer-setup.php');" > actual_checksum && \
    diff expected_checksum actual_checksum && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer --quiet && \
    rm composer-setup.php expected_checksum actual_checksum

## Healthcheck
RUN wget -O /usr/local/bin/php-fpm-healthcheck \
    https://raw.githubusercontent.com/renatomefi/php-fpm-healthcheck/master/php-fpm-healthcheck \
    && chmod +x /usr/local/bin/php-fpm-healthcheck

## Enable php fpm status page
RUN set -xe && echo "pm.status_path = /status" >> /usr/local/etc/php-fpm.d/zz-docker.conf

## Cleanup
RUN rm -rf /var/cache/apk/*

COPY conf/php.ini /usr/local/etc/php/conf.d/zzz-overrides.ini
COPY scripts/* /usr/local/bin/

# Explicitly set executable permissions for all scripts
RUN chmod +x /usr/local/bin/*

ARG USER_ID
ARG GROUP_ID

RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
  deluser www-data &&\
  if getent group www-data ; then delgroup www-data; fi &&\
  if getent group ${GROUP_ID} ; then delgroup $(getent group ${GROUP_ID} | cut -d: -f1); fi &&\
  addgroup -g ${GROUP_ID} -S www-data; \
  adduser -D -u ${USER_ID} -S -G www-data www-data \
;fi

USER www-data

EXPOSE 9000
