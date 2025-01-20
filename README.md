# Ovds™

[![Release](https://img.shields.io/github/v/release/Ovds/Ovds?label=release)](https://github.com/Ovds/Ovds/releases)
![Downloads](https://img.shields.io/github/downloads/Ovds/Ovds/total?label=downloads)
[![Translations](https://badges.crowdin.net/Ovds/localized.svg)](https://crowdin.com/project/Ovds)
[![Tests](https://img.shields.io/github/actions/workflow/status/Ovds/Ovds/tests.yml?label=tests)](https://github.com/Ovds/Ovds/actions)

Online accounting software designed for small businesses and freelancers. Ovds is built with modern technologies such as Laravel, VueJS, Tailwind, RESTful API etc. Thanks to its modular structure, Ovds provides an awesome App Store for users and developers.

* [Home](https://Ovds.com) - The house of Ovds
* [Forum](https://Ovds.com/forum) - Ask for support
* [Documentation](https://Ovds.com/hc/docs) - Learn how to use
* [Developer Portal](https://developer.Ovds.com) - Generate passive income
* [App Store](https://Ovds.com/apps) - Extend your Ovds
* [Translations](https://crowdin.com/project/Ovds) - Help us translate Ovds

## Requirements

* PHP 8.1 or higher
* Database (e.g.: MySQL, PostgreSQL, SQLite)
* Web Server (eg: Apache, Nginx, IIS)
* [Other libraries](https://Ovds.com/hc/docs/on-premise/requirements/)

## Framework

Ovds uses [Laravel](http://laravel.com), the best existing PHP framework, as the foundation framework and [Module](https://github.com/Ovds/module) package for Apps.

## Installation

* Install [Composer](https://getcomposer.org/download) and [Npm](https://nodejs.org/en/download)
* Clone the repository: `git clone https://github.com/Ovds/Ovds.git`
* Install dependencies: `composer install ; npm install ; npm run dev`
* Install Ovds:

```bash
php artisan install --db-name="Ovds" --db-username="root" --db-password="pass" --admin-email="admin@company.com" --admin-password="123456"
```

* Create sample data (optional): `php artisan sample-data:seed`

## Contributing

Please, be very clear on your commit messages and Pull Requests, empty Pull Request messages may be rejected without reason.

When contributing code to Ovds, you must follow the PSR coding standards. The golden rule is: Imitate the existing Ovds code.

Please note that this project is released with a [Contributor Code of Conduct](https://Ovds.com/conduct). *By participating in this project you agree to abide by its terms*.

## Translation

If you'd like to contribute translations, please check out our [Crowdin](https://crowdin.com/project/Ovds) project.

## Changelog

Please see [Releases](../../releases) for more information about what has changed recently.

## Security

Please review [our security policy](https://github.com/Ovds/Ovds/security/policy) on how to report security vulnerabilities.

## Credits

* [Denis Duliçi](https://github.com/denisdulici)
* [Cüneyt Şentürk](https://github.com/cuneytsenturk)
* [All Contributors](../../contributors)

## License

Ovds is released under the [BSL license](LICENSE.txt).
