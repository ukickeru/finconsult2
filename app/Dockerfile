FROM ukickeru/temporal-php AS backend

MAINTAINER Pavel Nikolaev <uk.i.c.k.e.ru@gmail.com>

# Copy application codebase
WORKDIR /var/app

COPY wait-for-temporal.sh /usr/local/bin
RUN chmod +x /usr/local/bin/wait-for-temporal.sh

COPY ./ ./

RUN composer install
# todo: remove dev dependencies and prepare app to production
# RUN composer install --no-dev --optimize-autoloader \
#     && composer dump-env prod

# Dump schema files
RUN php bin/console graphql:dump-schema --env=build --schema=public --file=schema/public.graphql --format=graphql
RUN php bin/console graphql:dump-schema --env=build --schema=root --file=schema/root.graphql --format=graphql

# Set volume with SSL keypair
VOLUME /var/app/config/certs/

# Setup RoadRunner
RUN vendor/bin/rr get -f 2.10.4 --no-interaction \
    && mv rr /usr/local/bin/rr \
    && chmod +x /usr/local/bin/rr

# Set up default ENV variables
ENV APP_ENV=dev
ENV APP_DEBUG=true
ENV TEMPORAL_NAMESPACE=default


# Frontend stage
FROM node:lts-slim as frontend

WORKDIR ./node
COPY ./frontend ./
RUN npm i
COPY --from=backend /var/app/schema ./schema
RUN npm run prod


# Last stage. Copy builded frontend & add new user
FROM backend AS run

RUN useradd -ms /bin/bash worker
WORKDIR /var/app
COPY --from=frontend ./node/build ./public
RUN chown -R worker:worker /var/app \
    && chmod +x /usr/local/bin/php
USER worker
