#!/bin/sh -e

while true
do
    php /www/admin.php clean_expired
    php /www/admin.php clean_async
    # wait 24 hours
    sleep 86400
done
