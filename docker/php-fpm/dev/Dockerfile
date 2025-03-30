FROM ghcr.io/wesleyvestjens/php-devops-animal-training-test/php-fpm:base

# Install xdebug extension
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS && \
    apk add --update linux-headers && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apk del -f .build-deps

# For coverage/development reasons
RUN mkdir -p /opt/phpstorm-coverage && chown www-data:www-data /opt/phpstorm-coverage

# Use development php ini
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && rm /usr/local/etc/php/php.ini-*

# Include Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Configure the environment for a separate user to run FPM
ARG HOST_UID=1000

USER "${HOST_UID}"
