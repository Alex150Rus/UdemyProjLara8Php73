FROM php:7.3-fpm-alpine

WORKDIR /var/www

RUN apk update && apk upgrade && apk add --no-cache \
      $PHPIZE_DEPS \
      build-base \
      npm\
      zip \
      unzip \
      vim \
      git \
      freetype \
      libjpeg-turbo \
      libpng \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && docker-php-ext-configure gd \
      --with-gd \
      --with-freetype-dir=/usr/include/ \
      --with-png-dir=/usr/include/ \
      --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && apk del --no-cache \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && rm -rf /tmp/*


RUN apk add libzip-dev

# Install mbstring extension
RUN apk add --no-cache \
    oniguruma-dev \
    && docker-php-ext-install mbstring \
    && docker-php-ext-enable mbstring \
    && rm -rf /tmp/*

RUN apk add --no-cache \
    icu-dev \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-enable intl \
    && rm -rf /tmp/*

RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl bcmath

# Install Redis Extension
RUN pecl install redis && docker-php-ext-enable redis

#Get latest composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#Copy config
COPY ./config/php/local.ini /usr/local/etc/php/conf.d/local.ini

RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

COPY --chown=www:www . /var/www
#if doesn't work change owner:group in wsl. Bug...
RUN chown -R www:www /var/www

USER www

EXPOSE 9000
