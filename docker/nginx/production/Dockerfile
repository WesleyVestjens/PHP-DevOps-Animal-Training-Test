FROM ghcr.io/wesleyvestjens/php-devops-animal-training-test/nginx:base

COPY --chown=nginx:nginx ./backend/public/ /var/www/html/public/

ARG HOST_UID=1000
USER "${HOST_UID}"
