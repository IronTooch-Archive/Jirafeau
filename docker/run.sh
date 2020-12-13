#!/bin/sh -e
/cleanup.sh &
php-fpm -D
php /docker_config.php
lighttpd -D -f /etc/lighttpd/lighttpd.conf
