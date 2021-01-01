#!/bin/sh -e
sleep 10 # avoid running cleaning before first setup
while true
do
    php /www/admin.php clean_expired
    php /www/admin.php clean_async
    # wait 24 hours
    sleep 86400
done
