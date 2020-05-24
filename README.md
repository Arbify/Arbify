<div align="center">
<h1>Arbify</h1>
    
[![PHP workflow][php-workflow-badge]][php-workflow]
</div>

![Screenshot](resources/images/screenshot.png)

ARB files localization tool. Dedicated to [Flutter](https://flutter.dev) and its [intl](https://pub.dev/packages/intl) package.

For documentation regarding source code of Arbify, check [DOCS.md](DOCS.md).

## Installation

Firstly, copy the `.env.example` file to `.env` and fill it with the correct configuration for some of the services.

```bash
cp .env.example .env
```

Fill `.env` file with the configuration you want to use.

**Note:** By default `MAIL_MAILER` uses SMTP transport; you may want to change that to `log` for development purposes.

```bash
docker-compose build arbify
docker-compose up -d
```

After this you're ready to go to [http://localhost:8000](http://localhost:8000) and check out Arbify yourself!

The database is seeded with a pre-verified super administrator account `admin@arbify.io` with password `password`. 

[php-workflow]: https://github.com/Arbify/Arbify/actions?query=workflow%3APHP
[php-workflow-badge]: https://github.com/Arbify/Arbify/workflows/PHP/badge.svg
