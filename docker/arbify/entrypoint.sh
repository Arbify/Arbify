#!/usr/bin/env bash

npm ci
npm run prod

composer install --no-interaction --no-suggest

if grep ^APP_KEY=$ .env; then
    php artisan -n key:generate
fi

# Wait until db is operational
echo "Waiting for db"
counter=1
while ! mysql -h db -u "${DB_USER}" --password="${DB_PASSWORD}" -e "SHOW DATABASES;" > /dev/null 2>&1; do
    sleep 1
    counter=`expr $counter + 1`
    if [ $counter -gt 60 ]; then
        >&2 echo "We have been waiting for db too long already; failing."
        exit 1
    fi
done

php artisan -n migrate
php artisan -n storage:link

php-fpm
