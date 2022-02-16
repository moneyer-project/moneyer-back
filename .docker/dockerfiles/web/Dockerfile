FROM php:8.1-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80
WORKDIR /app

RUN apt-get update
RUN apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        git-core \
        libxrender1 \
        libfontconfig1 \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        graphviz

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install apcu xdebug

RUN docker-php-ext-configure gd --enable-gd --with-jpeg --with-freetype
RUN docker-php-ext-install pdo pdo_mysql zip gd intl opcache
RUN docker-php-ext-enable apcu xdebug

COPY errors /errors
COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/app.conf
COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini

RUN a2enmod rewrite remoteip && a2enconf app
