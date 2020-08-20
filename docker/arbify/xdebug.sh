if [ "$APP_ENV" = "local" ]; then
    pecl install xdebug
    docker-php-ext-enable xdebug
fi
