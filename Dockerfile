FROM php:8-fpm
RUN apt-get update && \
    apt-get install -y libpq-dev iputils-ping && \
    docker-php-ext-install pdo pdo_pgsql pgsql
