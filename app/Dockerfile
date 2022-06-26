FROM php:8.0.15-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    nano \
    bash \
    libzip-dev \
    unzip \
    libonig-dev \
    libpq-dev \
    zlib1g-dev

# Install PHP Extensions
ENV CFLAGS="$CFLAGS -D_GNU_SOURCE"
RUN docker-php-ext-install zip \
  && docker-php-ext-install opcache sockets mbstring pdo_pgsql \
  && docker-php-ext-enable opcache sockets mbstring

# Protobuf
ENV PROTOBUF_VERSION "3.19.2"
RUN pecl channel-update pecl.php.net
RUN pecl install protobuf-${PROTOBUF_VERSION} \
    && docker-php-ext-enable protobuf

# GRPC
ENV GRPC_VERSION "1.46.3"
RUN pecl channel-update pecl.php.net
RUN pecl install grpc-${GRPC_VERSION} \
    && docker-php-ext-enable grpc

# Install Temporal CLI
COPY --from=temporalio/admin-tools /usr/local/bin/tctl /usr/local/bin/tctl

# Install Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Copy application codebase
WORKDIR /var/app

COPY wait-for-temporal.sh /usr/local/bin
RUN chmod +x /usr/local/bin/wait-for-temporal.sh

#RUN mkdir -p ./var/log \
##    && touch ./var/log/rr_worklog.log \
#    && chmod -Rf 666 ./var

COPY ./ ./

RUN composer install

# Setup RoadRunner
RUN vendor/bin/rr get -f 2.10.4 --no-interaction \
    && mv rr /usr/local/bin/rr \
    && chmod +x /usr/local/bin/rr

ENV APP_ENV=dev
ENV APP_DEBUG=true
