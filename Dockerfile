FROM php:7.4-fpm
COPY composer.lock composer.json /var/www/
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libssh2-1-dev libssh2-1 \
    nodejs \
    npm
RUN pecl install ssh2-1.2
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN npm i -g npm
RUN npm i -g n

RUN pecl install redis \
    && docker-php-ext-enable redis
RUN docker-php-ext-enable ssh2
RUN docker-php-ext-install pdo_mysql exif pcntl gd zip calendar
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
# Laravel-echo-server
#RUN npm install -g --no-lockfile laravel-echo-server \
 #   && npm cache clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash \
    && apt-get install nodejs -yq

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www

COPY --chown=www:www . /var/www

USER www

EXPOSE 9000
EXPOSE 6001
CMD ["php-fpm"]
