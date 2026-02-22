FROM php:8.3-apache-bookworm
LABEL maintainer="You <you@example.com>"

# Install required packages
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
        git \
        unzip \
        libxml2-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        zlib1g-dev \
        graphicsmagick && \
    docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install -j$(nproc) mysqli soap gd zip opcache intl exif && \
    a2enmod rewrite headers expires && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# PHP configuration for TYPO3
RUN echo "max_execution_time = 240\n\
max_input_vars = 1500\n\
upload_max_filesize = 32M\n\
post_max_size = 32M" > /usr/local/etc/php/conf.d/typo3.ini

# Set Apache document root to /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first
COPY composer.json composer.lock ./

# Copy local path repositories BEFORE running composer install
COPY packages ./packages

# Now install dependencies
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# Copy the rest
COPY . .

# Ensure required writable directories exist
RUN mkdir -p var public/fileadmin public/typo3temp public/_assets \
 && chown -R www-data:www-data var public/fileadmin public/typo3temp public/_assets

# Declare persistent volumes (same style as your previous image)
VOLUME /var/www/html/public/fileadmin
VOLUME /var/www/html/config/system
VOLUME /var/www/html/var