# Captcha for Laravel 5 & 6 & Lumen 6

A simple Lumen service provider for including the [Captcha for Laravel](https://github.com/1998-liu/redis-captcha).

for Lumen 6

## Preview
Based on [news/captcha](https://packagist.org/packages/mews/captcha?query=lumen-captcha)

## Installation

The Captcha Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`mews/captcha` package and setting the `minimum-stability` to `dev` (required for Lumen 6) in your
project's `composer.json`.

```json
{
    "require": {
        "nuary/redis-captcha": "^1.0"
    },
    "minimum-stability": "dev"
}
```

or

Require this package with composer:
```
composer require nuary/redis-captcha
```

Update your packages with ```composer update``` or install with ```composer install```.

In Windows, you'll need to include the GD2 DLL `php_gd2.dll` in php.ini. And you also need include `php_fileinfo.dll` and `php_mbstring.dll` to fit the requirements of `wtone/lumen-captcha`'s dependencies.


## Usage

To use the Captcha Service Provider, you must register session provider and captcha provider when bootstrapping your application. 




## Configuration

create a new file config/captcha.php

```php
return [
    'default'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'math'      => true, //Enable Math Captcha
    ],
    // ...
];
```

in `bootstrap/app.php`.
```php
    // regiseter Provider
    $app->register(Illuminate\Session\SessionServiceProvider::class);
    $app->register(Nuary\Captcha\CaptchaServiceProvider::class);
    // load config
    $app->configure('session');
    $app->configure('captcha');
    // set alias
    $app->alias('session', 'Illuminate\Session\SessionManager');
    $app->alias('Captcha', Nuary\Captcha\Facades\Captcha::class);
```
### make sure create folder "storage/framework/session" and chmod it


# Return Image
```php
captcha();
```
or
```php
Captcha::create();
```


# Check Captcha
```php
Captcha::check();
```

etc.



*_*

