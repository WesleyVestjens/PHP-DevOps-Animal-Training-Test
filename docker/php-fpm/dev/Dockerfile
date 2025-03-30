FROM ghcr.io/wesleyvestjens/php-devops-animal-training-test/php-fpm:base

# Use development php ini
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && rm /usr/local/etc/php/php.ini-*

# Include Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

USER 1000
