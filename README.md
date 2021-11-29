# Laravel PayHere intergration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lahirulhr/laravel-payhere.svg?style=flat-square)](https://packagist.org/packages/lahirulhr/laravel-payhere)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lahirulhr/laravel-payhere/run-tests?label=tests)](https://github.com/lahirulhr/laravel-payhere/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/lahirulhr/laravel-payhere/Check%20&%20fix%20styling?label=code%20style)](https://github.com/lahirulhr/laravel-payhere/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lahirulhr/laravel-payhere.svg?style=flat-square)](https://packagist.org/packages/lahirulhr/laravel-payhere)

<div align="center">

[<img src="https://www.fourninecloud.com/assets/images/laravel-design.png" height="150px">](http://laravel.com)
[<img src="https://www.payhere.lk/images/PayHere-Logo.png" height="150px">](http://payhere.lk)

</div>

Want to use PayHere as payment gateway of your laravel application. don't worry about API handling. use this simple package to connect PayHere API

```php

// adding payment details
$data = [
            'first_name' => 'Lahiru',
            'last_name' => 'Tharaka',
            'email' => 'lahirulhr@gmail.com',
            'phone' => '+94761234567',
            'address' => 'Main Rd',
            'city' => 'Anuradhapura',
            'country' => 'Sri lanka',
            'order_id' => '45552525005',
            'items' => 'Smart band MI 4 - BLACK',
            'currency' => 'LKR',
            'amount' => 4960.00,
        ];

// creating checkout page
        
PayHere::checkOut()
            ->data($data)
            ->successUrl('www.visanduma.com/payment-success')
            ->failUrl('www.visanduma.com/payment-fail')
            ->renderView();

```

## Installation

You can install the package via composer:

```bash
composer require lahirulhr/laravel-payhere
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Lahirulhr\PayHere\PayHereServiceProvider" --tag="laravel-payhere-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-payhere = new Lahirulhr\PayHere();
echo $laravel-payhere->echoPhrase('Hello, Lahirulhr!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [LaHiRu](https://github.com/lahirulhr)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
