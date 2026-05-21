# FrankenPHP – image officielle basée sur Debian
FROM dunglas/frankenphp:1-php8.4

WORKDIR /app
 
# Extensions PHP nécessaires pour Symfony + API Platform + PostgreSQL
RUN install-php-extensions \
    amqp \
    apcu \
    imap \
    intl \
    gd \
    mbstring \
    opcache \
    pcntl \
    pdo_pgsql \
    pgsql \
    xml \
    zip \
 	&& rm -rf /var/lib/apt/lists/*

###> recipes ###
###> doctrine/doctrine-bundle ###
RUN set -eux; \
	install-php-extensions pdo_pgsql
###< doctrine/doctrine-bundle ###


# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
 
COPY --link frankenphp/conf.d/10-app.ini $PHP_INI_DIR/app.conf.d/
COPY --link --chmod=755 frankenphp/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
COPY --link frankenphp/Caddyfile /etc/frankenphp/Caddyfile

ENTRYPOINT ["docker-entrypoint"]


ENV APP_ENV=dev
ENV XDEBUG_MODE=off
ENV FRANKENPHP_WORKER_CONFIG=watch
VOLUME /app/var/

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN set -eux; \
	install-php-extensions \
		xdebug \
	;

COPY --link frankenphp/conf.d/20-app.dev.ini $PHP_INI_DIR/app.conf.d/

CMD [ "frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile", "--watch" ]

# Création du projet Symfony + API Platform si le dossier est vide
# (ignoré si tu montes un projet existant via le volume ./symfony_app)
# RUN if [ ! -f composer.json ]; then \
#     composer create-project symfony/skeleton . --no-interaction && \
#     composer require \
#         api-platform/core \
#         doctrine/orm \
#         doctrine/doctrine-bundle \
#         doctrine/doctrine-migrations-bundle \
#         symfony/uid \
#         nelmio/cors-bundle \
#         --no-interaction; \
#     fi
 
EXPOSE 80