<?php

use Lahirulhr\PayHere\PayHere;

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
            ->submit();

        expect($client->status())->toEqual(200);
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

        $client = PayHere::subscription()
            ->data($data)
            ->successUrl('www.visanduma.com')
            ->failUrl('www.visanduma.com')
            ->chargeMonthly(2)
            ->forYears()
            ->submit();

        expect($client->status())->toEqual(200);
    }
);


it('can create preapproval page', function () {
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
        ->submit();

    expect($client->status())->toEqual(200);
});

it('can get access token', function () {
    $client = (new \Lahirulhr\PayHere\Helpers\PayHereClient());
    expect($client->getAccessToken()['token_type'])->toEqual('bearer');
});
