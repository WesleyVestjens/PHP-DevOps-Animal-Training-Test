FROM ghcr.io/wesleyvestjens/php-devops-animal-training-test/php-fpm:base

# Use production php ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && rm /usr/local/etc/php/php.ini-*

COPY --chown=www-data:www-data ./backend/ /var/www/html/

ARG HOST_UID=1000
USER "${HOST_UID}"
