FROM php:8.4-fpm-alpine

LABEL org.opencontainers.image.source=https://github.com/WesleyVestjens/PHP-DevOps-Animal-Training-Test

# Set default timezone
RUN sed -ri -e 's!;date.timezone =!date.timezone = "Europe/Amsterdam"!g' /usr/local/etc/php/php.ini-production
RUN sed -ri -e 's!;date.timezone =!date.timezone = "Europe/Amsterdam"!g' /usr/local/etc/php/php.ini-development

# Add shadow to modify user config
RUN apk --no-cache add shadow

# Configure the environment for a separate user to run FPM
ARG HOST_UID=1000
ARG HOST_GID=1000

# Modify use rand group settings and remove shadow
RUN groupmod --gid "${HOST_GID}" www-data && usermod --uid "${HOST_UID}" --gid "${HOST_GID}" www-data
RUN apk del shadow

# FPM deescalation policy
RUN mkdir -p /var/www/html/public/ /usr/local/var/run/php-fpm/
RUN chown www-data:www-data -R /var/www/ /usr/local/var/run/php-fpm/ /usr/local/etc/php/ /usr/local/etc/php-fpm.d/

# FPM config
COPY --chown=www-data:www-data configuration/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY --chown=www-data:www-data configuration/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY --chown=www-data:www-data configuration/php.ini /usr/local/etc/php/conf.d/zz_php.ini
