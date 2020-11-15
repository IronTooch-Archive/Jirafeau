FROM php:7.3-fpm-alpine
MAINTAINER "Jérôme Jutteau <jerome@jutteau.fr>"
ARG USER_UID=2009

# install base
RUN apk update && \
    ln -snf /usr/share/zoneinfo/Etc/UTC /etc/localtime  && \
    echo "UTC" > /etc/timezone


# install jirafou
RUN mkdir /www
WORKDIR /www
COPY .git .git
RUN apk add git && \
    git reset --hard && rm -rf .git .gitignore .gitlab-ci.yml CONTRIBUTING.md Dockerfile README.md && \
    apk del git && \
    chown -R $USER_UID /www && \
    chmod o=,ug=rwX -R /www && \
    chmod +x docker/cleanup


# install lighttpd
RUN apk add lighttpd php7-mcrypt && \
    echo "extension=/usr/lib/php7/modules/mcrypt.so" > /usr/local/etc/php/conf.d/mcrypt.ini && \
    chown -R $USER_UID /var/log/lighttpd && \
    chmod oug=rwX /run && \
    mkdir -p /usr/local/etc/php
COPY docker/php.ini /usr/local/etc/php/php.ini
COPY docker/lighttpd.conf /etc/lighttpd/lighttpd.conf


# cleanup
RUN rm -rf /var/cache/apk/*


CMD /www/docker/cleanup & php-fpm -D && lighttpd -D -f /etc/lighttpd/lighttpd.conf
EXPOSE 80
