FROM alpine:3.9

# set main params
ARG BUILD_ARGUMENT_DEBUG_ENABLED=true
ENV DEBUG_ENABLED=$BUILD_ARGUMENT_DEBUG_ENABLED
ENV ENV=prod
ENV APP_HOME /var/www/html
ENV APP_ROOT /
ENV USERNAME=www-data

# PHP_INI_DIR to be symmetrical with official php docker image
ENV PHP_INI_DIR /etc/php/7.4

# When using Composer, disable the warning about running commands as root/super user
ENV COMPOSER_ALLOW_SUPERUSER=1

# Persistent runtime dependencies
ARG DEPS="\
        nginx \
        nginx-mod-http-headers-more \
        php7.4 \
        php7.4-phar \
        php7.4-bcmath \
        php7.4-calendar \
        php7.4-mbstring \
        php7.4-exif \
        php7.4-ftp \
        php7.4-openssl \
        php7.4-zip \
        php7.4-sysvsem \
        php7.4-sysvshm \
        php7.4-sysvmsg \
        php7.4-shmop \
        php7.4-sockets \
        php7.4-zlib \
        php7.4-bz2 \
        php7.4-curl \
        php7.4-simplexml \
        php7.4-xml \
        php7.4-opcache \
        php7.4-dom \
        php7.4-xmlreader \
        php7.4-xmlwriter \
        php7.4-tokenizer \
        php7.4-ctype \
        php7.4-session \
        php7.4-fileinfo \
        php7.4-iconv \
        php7.4-json \
        php7.4-posix \
        php7.4-fpm \
        mysql-client \
        curl \
        ca-certificates \
        runit \
"

# PHP.earth Alpine repository for better developer experience
ADD https://repos.php.earth/alpine/phpearth.rsa.pub /etc/apk/keys/phpearth.rsa.pub

RUN set -x \
    && echo "https://repos.php.earth/alpine/v3.9" >> /etc/apk/repositories \
    && apk add --no-cache $DEPS \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer

# copy source files and config file
COPY docker/nginx /
COPY . $APP_HOME
COPY .env.$ENV $APP_HOME/.env

# set working directory
WORKDIR $APP_HOME

# install all PHP dependencies
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader --no-interaction --no-progress;

RUN chmod -R 777 $APP_HOME/bootstrap/cache
RUN chmod -R 777 $APP_HOME/storage

RUN php artisan cache:clear
RUN php artisan config:clear

# set working directory
WORKDIR $APP_ROOT

EXPOSE 8080

CMD ["/sbin/runit-wrapper"]
