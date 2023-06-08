FROM composer:2.0 as step0

WORKDIR /src/

COPY composer.lock /src/
COPY composer.json /src/

RUN composer update --ignore-platform-reqs --optimize-autoloader \
    --no-plugins --no-scripts --prefer-dist

FROM php:8.0-cli-alpine as step1

## Last working commit https://github.com/Imagick/imagick/commit/35741750aa1cda2b7ac354bfa6128fa037e9cf32
ENV PHP_IMAGICK_VERSION=3.7.0
    
RUN \
  apk add --no-cache --virtual .deps \
  make \
  automake \
  autoconf \
  gcc \
  g++ \
  git \
  imagemagick \
  imagemagick-dev

## Imagick Extension
RUN \
  git clone --depth 1 --branch $PHP_IMAGICK_VERSION https://github.com/imagick/imagick && \
  cd imagick && \
  phpize && \
  ./configure && \
  make && make install

FROM php:8.0-cli-alpine as final

LABEL maintainer="team@appwrite.io"

RUN \
  apk update \
  && apk add --no-cache --virtual .deps \
  make \
  automake \
  autoconf \
  gcc \
  g++ \
  && apk add --no-cache \
  libstdc++ \
  libgomp \
  imagemagick \
  && apk del .deps \
  && rm -rf /var/cache/apk/*

WORKDIR /code

COPY --from=step0 /src/vendor /code/vendor
COPY --from=step1 /usr/local/lib/php/extensions/no-debug-non-zts-20200930/imagick.so /usr/local/lib/php/extensions/no-debug-non-zts-20200930/

# Add Source Code
COPY ./tests /code/tests
COPY ./src /code/src
COPY ./phpunit.xml /code/phpunit.xml
COPY ./pint.json /code/pint.json

RUN echo extension=imagick.so >> /usr/local/etc/php/conf.d/imagick.ini

CMD [ "sh", "-c", "/code/vendor/bin/phpunit --verbose --configuration /code/phpunit.xml && /code/vendor/bin/pint -v --test" ]