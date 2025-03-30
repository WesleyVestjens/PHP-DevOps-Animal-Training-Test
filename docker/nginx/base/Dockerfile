FROM nginx:alpine

# Labeling for GitHub
LABEL org.opencontainers.image.source=https://github.com/WesleyVestjens/PHP-DevOps-Animal-Training-Test

# Add shadow to modify user config
RUN apk --no-cache add shadow

# Configure the environment for a separate user to run Nginx
ARG HOST_UID=1000
ARG HOST_GID=1000

# Modify use rand group settings and remove shadow
RUN groupmod --gid "${HOST_GID}" nginx && usermod --uid "${HOST_UID}" --gid "${HOST_GID}" nginx
RUN apk del shadow

# Nginx deescalation policy
RUN mkdir -p /var/cache/nginx/ /var/run/nginx/ /var/www/html/public/
RUN chown nginx:nginx -R /var/cache/nginx/ /var/run/nginx/ /var/www/ /etc/nginx/

# Nginx config
RUN rm /etc/nginx/conf.d/default.conf
COPY --chown=nginx:nginx configuration/nginx.conf /etc/nginx/nginx.conf
COPY --chown=nginx:nginx configuration/api.conf /etc/nginx/conf.d/api.conf
COPY --chown=nginx:nginx configuration/security.conf /etc/nginx/conf.d/security.conf
