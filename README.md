![Screenshot](https://raw.githubusercontent.com/bfg/markdown-generator/master/art/screenshot.jpg)

# Markdown generator

[![Latest Stable Version](https://poser.pugx.org/bfg/markdown-generator/version.svg)](https://packagist.org/packages/bfg/markdown-generator)
[![License](https://poser.pugx.org/bfg/markdown-generator/license.svg)](https://packagist.org/packages/bfg/markdown-generator)
[![Downloads](https://poser.pugx.org/bfg/markdown-generator/d/total.svg)](https://packagist.org/packages/bfg/markdown-generator)

Generator of standard Markdown in PHP style

## Installation

```bash
composer require bfg/markdown-generator
```
after install your package please run this command

```bash
php artisan markdown-generator:install
```



## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="markdown-generator-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="markdown-generator-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="markdown-generator-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="markdown-generator-migrations"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Xsaven](mailto:xsaven@gmail.com)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
