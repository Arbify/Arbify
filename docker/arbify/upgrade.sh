#!/usr/bin/env bash
set -e

echo "1/5   Downloading Composer depencencies..."
composer install --no-interaction --no-suggest

if grep -q ^APP_KEY=$ .env; then
    echo "1.5/5 Generating application key..."
    php artisan -n key:generate
fi

# Wait until db is operational
echo "2/5   Running migrations on database..."
counter=1
while ! mysql -h db -u "${DB_USER}" --password="${DB_PASSWORD}" -e "SHOW DATABASES;" > /dev/null 2>&1; do
    sleep 1
    counter=`expr ${counter} + 1`
    if [[ ${counter} -gt 10 ]]; then
        >&2 echo "2/5   Running migrations on database FAILED. Could not establish database connection."
        exit 1
    fi
done

php artisan -n migrate

echo "3/5 Creating symlinks..."
php artisan -n storage:link

echo "4/5   Downloading npm dependencies..."
npm ci

echo "5/5   Compiling frontend files..."
npm run prod

echo "      Done!"
