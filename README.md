# A Laravel Nova tool to display broken links and mixed content

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ohdearapp/nova-ohdear-tool.svg?style=flat-square)](https://packagist.org/packages/ohdearapp/nova-ohdear-tool)
[![Build Status](https://img.shields.io/travis/ohdearapp/nova-ohdear-tool/master.svg?style=flat-square)](https://travis-ci.org/ohdearapp/nova-ohdear-tool)
[![Quality Score](https://img.shields.io/scrutinizer/g/ohdearapp/nova-ohdear-tool.svg?style=flat-square)](https://scrutinizer-ci.com/g/ohdearapp/nova-ohdear-tool)
[![Total Downloads](https://img.shields.io/packagist/dt/ohdearapp/nova-ohdear-tool.svg?style=flat-square)](https://packagist.org/packages/ohdearapp/nova-ohdear-tool)

Have you always wanted to see your application log in your Nova app? Now you can!

![ohdear tool screenshot](https://ohdearapp.github.io/nova-ohdear-tool/tail-tool.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require ohdearapp/nova-ohdear-tool
```

Next up, you must register the tool with Nova. This is typically done in the `register` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvder.php

// ...

public function register()
{
    Nova::tools([
        // ...
        new \OhDear\OhDearTool\OhDearTool(),
    ]);
}
```

## Usage

Click on the "Oh Dear!" menu item in your Nova app to see the broken links and mixed content of your site.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@ohdearapp.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Ohdearapp, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://ohdearapp.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
