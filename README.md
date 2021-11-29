# Laravel PayHere

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lahirulhr/laravel-payhere.svg?style=flat-square)](https://packagist.org/packages/lahirulhr/laravel-payhere)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lahirulhr/laravel-payhere/run-tests?label=tests)](https://github.com/lahirulhr/laravel-payhere/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/lahirulhr/laravel-payhere/Check%20&%20fix%20styling?label=code%20style)](https://github.com/lahirulhr/laravel-payhere/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lahirulhr/laravel-payhere.svg?style=flat-square)](https://packagist.org/packages/lahirulhr/laravel-payhere)

<div align="center">

[<img src="https://www.fourninecloud.com/assets/images/laravel-design.png" height="150px">](http://laravel.com)
[<img src="https://www.payhere.lk/images/PayHere-Logo.png" height="150px">](http://payhere.lk)

</div>

Want to use PayHere as payment gateway of your laravel application. don't worry about API handling. use this simple package to connect PayHere API

####Available API methods
* Checkout API
* Recurring API
* Preapproval API
* Charging API
* Retrieval API
* Subscription Manager API
* Refund API
* Authorize API
* Capture API

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


    /*
     PayHere action url. usually,
     for production   https://www.payhere.lk
     for testing  https://sandbox.payhere.lk
      remember to update api when production
     * */

    'api_endpoint' => env('PAYHERE_API'),


    /*
      PayHere merchant ID can be found in their dashboard
      https://www.payhere.lk/account/settings/domain-credentials
     * */

    'merchant_id' => env('PAYHERE_MERCHANT_ID'),

    /*
     Merchant Secret is specific to each App/Domain. it can be generated for your domain/app as follows
     https://www.payhere.lk/account/settings/domain-credentials
        *Click 'Add Domain/App' > Fill details > Click 'Request to Allow'
        *Wait for the approval for your domain
        *Copy the Merchant Secret for your domain/app to .env file
     * */
    'merchant_secret' => env('PAYHERE_MERCHANT_SECRET'),


    /*
     Follow PayHere official instructions to obtain 'app_id' and 'app_secret'.
     NOTE: you dont need to generate "Authorization code". it will be automatically generate by this package
        *Sign in to your PayHere account & go to Settings > Business Apps section
        *Click 'Create App' button & enter an app name & comma seperated domains to whilelist
        *Tick the permission 'Payment Retrieval API'
        *Click 'Add Business App' button to create the app
        *Once the app is created click 'View Credential' button in front of the created app
        *Copy the 'App ID' & 'App Secret' values
     * */
    'app_id' => env('PAYHERE_APP_ID'),
    'app_secret' => env('PAYHERE_APP_SECRET'),
```

## Usage


###### Checkout Page
```php
// in your controller

use Lahirulhr\PayHere\PayHere;

// prepair posting data

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

// creating checkout page & ridirect the user  

return PayHere::checkOut()
            ->data($data)
            ->setOptionalData() // Set optional data. see PayHere documantaion for available values
            ->successUrl('www.visanduma.com/payment-success')
            ->failUrl('www.visanduma.com/payment-fail')
            ->renderView();
```


###### Recurring API
Recurring API is accept data array same as checkout API. the only things you need to change checkOut() method
to recurring()

```php
return PayHere::recurring()
            ->data($data)
            ->setOptionalData() // Set optional data. see PayHere documantaion for available values
            ->successUrl('www.visanduma.com')
            ->failUrl('www.visanduma.com')
            ->chargeMonthly(2)
            ->forYears()
            ->renderView();
```

The following options are available for making adjustment to recurring period

```php
// Charging interval (Recurrence)
PayHere::recurring()->chargeWeekly(2) // charge per specific period of weeks .the default value is one week
PayHere::recurring()->chargeMonthly(3) // charge per specific period of months .the default value is one month
PayHere::recurring()->chargeAnnually() // charge per specific period of years .the default value is one year

// Duration to charge 
PayHere::recurring()->forWeeks(6) // set duratoin by weeks .the default value is one week
PayHere::recurring()->forMonths(3) // set duratoin by months .the default value is one month
PayHere::recurring()->forYears() // set duratoin by years .the default value is one year
PayHere::recurring()->forForever() // set charging period to infinity.
```

###### Preapproval API

Use same as checkout method

```php
return PayHere::preapproval()
            ->data($data)
            ->setOptionalData() // Set optional data. see PayHere documantaion for available values
            ->successUrl('www.visanduma.com/payment-success')
            ->failUrl('www.visanduma.com/payment-fail')
            ->renderView();
```

## TODO

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
