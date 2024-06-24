# Laravel PayHere

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lahirulhr/laravel-payhere.svg?style=flat-square)](https://packagist.org/packages/lahirulhr/laravel-payhere)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lahirulhr/laravel-payhere/run-tests?label=tests)](https://github.com/lahirulhr/laravel-payhere/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/lahirulhr/laravel-payhere/Check%20&%20fix%20styling?label=code%20style)](https://github.com/lahirulhr/laravel-payhere/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lahirulhr/laravel-payhere.svg?style=flat-square)](https://packagist.org/packages/lahirulhr/laravel-payhere)

<div align="center">

[<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Laravel_logotype_min.svg/2560px-Laravel_logotype_min.svg.png" height="100px">](http://laravel.com)
    <br>
[<img src="https://payherestorage.blob.core.windows.net/payhere-resources/www/images/PayHere-Logo.png" height="100px">](http://payhere.lk)

</div>

Laravel - PayHere was  made to manage PayHere payment gateway on your laravel application with ease. currently this package supports all 
available methods on official PayHere documentation.

Read official [Documentation](https://support.payhere.lk/api-&-mobile-sdk/payhere-checkout)  for more information

#### Available API methods
✔️ Checkout API  
✔️ Recurring API  
✔️ Preapproval API  
✔️ Charging API  
✔️ Retrieval API  
✔️ Subscription Manager API  
✔️ Refund API  
✔️ Authorize API  
✔️ Capture API  


###### Basic Usage
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

// creating checkout page & redirect user
        
return PayHere::checkOut()
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


###### [Checkout API](https://support.payhere.lk/api-&-mobile-sdk/payhere-checkout)
Checkout API lets you integrate PayHere with your website, web application or any other application in code level.
 It offers a simple HTML Form to initiate a payment request and redirect
 your customer to PayHere Payment Gateway to securely process the payment.
 
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
            ->successUrl('www.visanduma.com/success')
            ->failUrl('www.visanduma.com/fail')
            ->renderView();
```

#### Handling the server callback
PayHere will be notified your application with response data using public url POST request callback. 
then this package will emit a new event with their
callback data. you just need to listen on an event and do anything you want with payload data.

#### Available Events
* AuthorizeCallbackEvent
* CheckoutCallbackEvent
* PreapprovalCallbackEvent
* RecurringCallbackEvent

Example: 
```php
            
// define listners in your EventServiceProvider.php

class EventServiceProvider extends ServiceProvider
{

    use Lahirulhr\PayHere\Events\CheckoutCallbackEvent;
    
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CheckoutCallbackEvent::class => [
            // register listeners to do something with callback
            SomeListener::class 
        ],
    ];
    
}

class SomeListener{

    //....
    
     public function handle($event)
    {
     // you can access payhere callback data using $event->payload 
        Log::info($event->payload);
    }

}

```


###### [Recurring API](https://support.payhere.lk/api-&-mobile-sdk/payhere-recurring)
Recurring API is accept data array same as checkout API. the only things you need to change checkOut() method
to recurring().


```php
return PayHere::recurring()
            ->data($data)
            ->setOptionalData() // Set optional data. see PayHere documantaion for available values
            ->successUrl('www.visanduma.com/success')
            ->failUrl('www.visanduma.com/fail')
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

```php
// use this event to recieve server callback. see above example on Checkout API 
RecurringCallbackEvent::class
```

###### [Preapproval API](https://support.payhere.lk/api-&-mobile-sdk/payhere-preapproval)

Use same as checkout method

```php
return PayHere::preapproval()
            ->data($data)
            ->setOptionalData() // Set optional data. see PayHere documantaion for available values
            ->successUrl('www.visanduma.com/payment-success')
            ->failUrl('www.visanduma.com/payment-fail')
            ->renderView();
```

```php
// use this event to recieve server callback. see above example on Checkout API 
PreapprovalCallbackEvent::class
```

###### [Charging API](https://support.payhere.lk/api-&-mobile-sdk/payhere-charging)

Charging API lets you charge your preapproved customers programatically on demand using the encrypted tokens. it will return response data array on success
or return PayHereException if any error.

```php
$data = [
        "type" => "PAYMENT",
        "order_id" => "Order12345",
        "items" => "Taxi Hire 123",
        "currency" => "LKR",
        "amount" => 345.67,
    ];

$response =  PayHere::charge()
        ->byToken("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx") // customer token
        ->withData($data)
        ->submit();
```


###### [Retrieval API](https://support.payhere.lk/api-&-mobile-sdk/payhere-retrieval)

Retrieval API lets you retrieve the details of the Successful payments processed through your PayHere

```php
$info = PayHere::retrieve()
        ->orderId("od-43784658374534") // order number that you use to charge from customer
        ->submit();
```

##### [Subscription Manager](https://support.payhere.lk/api-&-mobile-sdk/payhere-subscription)
Subscription Manager API lets you view, retry & cancel your subscription customers programmatically you subscribed from Recurring API.

```php
// get all subscriptions
$subscriptions = PayHere::subscription()->getAll();

// get payment details of specific subscription
$paymentInfo = PayHere::subscription()
        ->getPaymentsOfSubscription("420075032251"); // subscription ID
        
// retry on failed supscription payments
PayHere::subscription()
        ->retry("420075032251"); // subscription ID
        
// cancel a subscription
PayHere::subscription()
        ->cancel("420075032251"); // subscription ID
```


###### [Refund API](https://support.payhere.lk/api-&-mobile-sdk/payhere-refund) 
Refund API lets you refund your existing payment programmatically.

```php
PayHere::refund()
        ->makePaymentRefund('320027150501') // payment_id
        ->note("Out of stock") // note for refund
        ->submit();
```

###### [Authorize API](https://support.payhere.lk/api-&-mobile-sdk/payhere-authorize)
Authorize API allows you to get your customer authorization for Hold on Card payments. this method will redirect user to payment page

```php
// use same $data as Checkout method

return PayHere::authorize()
        ->data($data)
        ->successUrl('www.visanduma.com/success')
        ->failUrl('www.visanduma.com/fail')
        ->renderView();
        
```

```php
// use this event to recieve server callback. see above example on Checkout API 
AuthorizeCallbackEvent::class
```

###### [Capture API](https://support.payhere.lk/api-&-mobile-sdk/payhere-capture)

Capture API lets you capture your authorized Hold on Card payments programmatically on demand using the authorization
 tokens you retrieved from Payment Authorize API.
 
 ```php
$response =  PayHere::capture()
         ->usingToken('e34f3059-7b7d-4b62-a57c-784beaa169f4') // authorization token
         ->amount(100) // charging amount
         ->reason("reason for capture")
         ->submit();
 ```
 
---

## TODO

- [x] ~~Events for server callbacks~~
- [ ] Custom payment redirection page
- [ ] Custom Error types
- [ ] Response Data Objects
- [ ] Optional Data handling
- [ ] Inbuilt subscription database
- [ ] Server callback log 

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
