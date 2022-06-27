FROM ukickeru/temporal-php

MAINTAINER Pavel Nikolaev <uk.i.c.k.e.ru@gmail.com>

# Copy application codebase
WORKDIR /var/app

COPY wait-for-temporal.sh /usr/local/bin
RUN chmod +x /usr/local/bin/wait-for-temporal.sh

COPY ./ ./

RUN composer install

# Setup RoadRunner
RUN vendor/bin/rr get -f 2.10.4 --no-interaction \
    && mv rr /usr/local/bin/rr \
    && chmod +x /usr/local/bin/rr

ENV APP_ENV=dev
ENV APP_DEBUG=true
ENV TEMPORAL_NAMESPACE=default
