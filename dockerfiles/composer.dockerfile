FROM composer:2

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

# macos cleanup
RUN delgroup dialout

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

WORKDIR /var/www/html