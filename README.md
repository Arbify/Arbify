# Arbify

[![PHP workflow][php-workflow-badge]][php-workflow]

ARB files localization tool. Dedicated to [Flutter](https://flutter.dev) and its [intl](https://pub.dev/packages/intl) package.

For documentation regarding source code of Arbify, check [DOCS.md](DOCS.md).

## Installation

For installation using docker-compose.

```bash
cp .env.example .env
```

Fill `.env` file with the configuration you want to use.

- If you're using docker-compose, you need to change `DB_HOST` to `db`.
- By default `MAIL_MAILER` uses SMTP transport; you may want to change that to `log` for development purposes.

```bash
docker-compose build arbify
docker-compose up -d

docker-compose run arbify composer install
docker-compose run arbify php artisan key:generate
docker-compose run arbify php artisan migrate
docker-compose run arbify php artisan db:seed
docker-compose run arbify npm install
docker-compose run arbify npm run prod
```

The `php artisan db:seed` command seeded the database with a pre-verified admin account with email `admin@arbify.io` and password `password`.

[php-workflow]: https://github.com/Arbify/Arbify/actions?query=workflow%3APHP
[php-workflow-badge]: https://github.com/Arbify/Arbify/workflows/PHP/badge.svg
