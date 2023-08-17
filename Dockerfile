FROM php:8.1.8

WORKDIR /app

COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

COPY composer.json composer.json
COPY composer.lock composer.lock

COPY src src
COPY tests tests

RUN apt-get update \
    && apt-get install -y libzip-dev zip \
    && docker-php-ext-install zip \
    && composer install --no-scripts --no-ansi --no-interaction --no-progress --optimize-autoloader --ignore-platform-reqs

ENTRYPOINT ["composer"]
ENV SHOW=0
