#!/usr/bin/env sh

cp -r /app/. /var/www/html
composer install --working-dir=/var/www/html

touch /ready
