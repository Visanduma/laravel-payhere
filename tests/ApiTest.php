<?php

use Illuminate\View\View;
use Lahirulhr\PayHere\Api\Checkout;
use Lahirulhr\PayHere\Exceptions\PayHereException;
use Lahirulhr\PayHere\Helpers\PayHereRestClient;
use Lahirulhr\PayHere\PayHere;

use function Pest\Laravel\post;

it('can read configs', function () {
    expect(config('payhere.api_endpoint'))->toBeString();
});

it(
    'can create checkout page',
    function () {
        $faker = \Faker\Factory::create();


        $data = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'city' => $faker->city,
            'country' => $faker->country,
            'order_id' => $faker->asciify(),
            'items' => $faker->word(),
            'currency' => 'USD',
            'amount' => $faker->numberBetween(100, 1000),
        ];

        $client = PayHere::checkOut()
            ->data($data)
            ->successUrl('www.visanduma.com')
            ->failUrl('www.visanduma.com')
            ->renderView();

        expect($client)->toBeInstanceOf(View::class);
    }
);

it(
    'can create recurring checkout page',
    function () {
        $faker = \Faker\Factory::create();


        $data = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'city' => $faker->city,
            'country' => $faker->country,
            'order_id' => $faker->asciify(),
            'items' => $faker->word(),
            'currency' => 'USD',
            'amount' => $faker->numberBetween(100, 1000),
        ];

        $client = PayHere::recurring()
            ->data($data)
            ->successUrl('www.visanduma.com')
            ->failUrl('www.visanduma.com')
            ->chargeMonthly(2)
            ->forYears()
            ->renderView();

        expect($client)->toBeInstanceOf(View::class);
    }
);


it('can create pre approval page', function () {
    $faker = \Faker\Factory::create();


    $data = [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'country' => $faker->country,
        'order_id' => $faker->asciify(),
        'items' => $faker->word(),
        'currency' => 'USD',
    ];

    $client = PayHere::preapproval()
        ->data($data)
        ->successUrl('www.visanduma.com')
        ->failUrl('www.visanduma.com')
        ->renderView();

    expect($client)->toBeInstanceOf(View::class);
});

it('can get access token', function () {
    $client = (new \Lahirulhr\PayHere\Helpers\PayHereRestClient());
    expect($client->getAccessToken())->toBeString();
});

it('can catch exception of charge api', function () {
    $data = [
        "type" => "PAYMENT",
        "order_id" => "Order12345",
        "items" => "Taxi Hire 123",
        "currency" => "LKR",
        "amount" => 345.67,
    ];

    return PayHere::charge()
        ->byToken("akshdkajshdjsyyyusydu") // Fake incorrect customer token
        ->withData($data)
        ->submit();
})->throws(PayHereException::class);


it('can retrieve payment data', function () {
    $client = PayHere::retrieve()
        ->orderId("od-43784658374534")
        ->submit();

    expect($client)->toBeArray();
});

it('can get subscription list', function () {
    $client = PayHere::subscription()->getAll();

    expect($client)->toBeArray();
});

it('can get payments of subscription', function () {
    $client = PayHere::subscription()
        ->getPaymentsOfSubscription("420075032251");

    expect($client)->toBeArray();
});


it('can retry on failed subscription (Using FAKE id)', function () {
    return  PayHere::subscription()
        ->retry("420075032251"); // fake subscription id expect error
})->throws(PayHereException::class);


it('can cancel the subscription (Using FAKE id)', function () {
    return  PayHere::subscription()
        ->cancel("420075032251"); // fake subscription id expect error
})->throws(PayHereException::class);


it('can make payment refund', function () {
    return  PayHere::refund()
        ->makePaymentRefund('320027150501') // expect error with FAKE payment_id
        ->note("reason for refund")
        ->submit();
})->throws(PayHereException::class);


it('can authorize payment & keep hold on card', function () {
    $faker = \Faker\Factory::create();


    $data = [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'country' => $faker->country,
        'order_id' => $faker->asciify(),
        'items' => $faker->word(),
        'currency' => 'USD',
        'amount' => $faker->numberBetween(100, 1000),
    ];

    $client = PayHere::authorize()
        ->data($data)
        ->successUrl('www.visanduma.com')
        ->failUrl('www.visanduma.com')
        ->renderView();

    expect($client)->toBeInstanceOf(View::class);
});

it('can capture payment', function () {
    return  PayHere::capture()
        ->usingToken('e34f3059-7b7d-4b62-a57c-784beaa169f4')
        ->amount(100)
        ->reason("reason for capture")
        ->submit();
})->throws(PayHereException::class);


it('can generate auth code', function () {
    $ob = new PayHereRestClient();
    $code = "NE9WeDNhS2hQbzg0SkREU0lvUkg1bjNMSDo4WDZRd3hCMWF2RTRmWGx3RmwzTWZlNHZXNjdLcVZzeko0dVRQakttczh1Yg==";
    expect($ob->generateAuthCode())
        ->toEqual($code);
});


it('has working callback routes', function () {
    post('payhere/callback/' . Checkout::getCallbackKey())->assertStatus(200);
});
