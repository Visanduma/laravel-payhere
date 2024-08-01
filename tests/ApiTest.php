<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Lahirulhr\PayHere\Api\Authorize;
use Lahirulhr\PayHere\Api\Checkout;
use Lahirulhr\PayHere\Api\PreApproval;
use Lahirulhr\PayHere\Api\Recurring;
use Lahirulhr\PayHere\Events\AuthorizeCallbackEvent;
use Lahirulhr\PayHere\Events\CheckoutCallbackEvent;
use Lahirulhr\PayHere\Events\PreApprovalCallbackEvent;
use Lahirulhr\PayHere\Events\RecurringCallbackEvent;
use Lahirulhr\PayHere\Exceptions\PayHereException;
use Lahirulhr\PayHere\Helpers\PayHereRestClient;
use Lahirulhr\PayHere\PayHere;

use function Pest\Laravel\post;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

it('can read configs', function () {
    expect(config('payhere.api_endpoint'))->toBeString();
});

it('can obtain access token', function () {

    $response = <<<'JSON'
        {
            "access_token": "cb5c47fd-741c-489a-b69e-fd73155ca34e",
            "token_type": "bearer",
            "expires_in": 599,
            "scope": "SANDBOX"
        }
    JSON;

    Http::fake([
        'payhere.lk/*' => Http::response(json_decode($response, true)),
    ]);

    $client = new PayHereRestClient();
    $token = $client->getAccessToken();

    assertEquals($token, 'cb5c47fd-741c-489a-b69e-fd73155ca34e');

    assertNotNull($token);

    assertEquals($token, $client->cachedAccessToken());

});

it('can create checkout page', function () {
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

    expect($client)->toBeInstanceOf(RedirectResponse::class);
}
);

it('can create recurring checkout page', function () {
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

    expect($client)->toBeInstanceOf(RedirectResponse::class);
});

it('can catch exception of charge api', function () {
    $data = [
        'type' => 'PAYMENT',
        'order_id' => 'Order12345',
        'items' => 'Taxi Hire 123',
        'currency' => 'LKR',
        'amount' => 345.67,
    ];

    return PayHere::charge()
        ->byToken('akshdkajshdjsyyyusydu') // Fake incorrect customer token
        ->withData($data)
        ->submit();
})->throws(PayHereException::class);

it('can retrieve payment data', function () {
    $client = PayHere::retrieve()
        ->orderId('od-43784658374534')
        ->submit();

    expect($client)->toBeArray();
});

it('can get subscription list', function () {
    $client = PayHere::subscription()->getAll();

    expect($client)->toBeArray();
});

it('can get payments of subscription', function () {
    $client = PayHere::subscription()
        ->getPaymentsOfSubscription('420075032251');

    expect($client)->toBeArray();
});

it('can retry on failed subscription (Using FAKE id)', function () {
    return PayHere::subscription()
        ->retry('420075032251'); // fake subscription id expect error
})->throws(PayHereException::class);

it('can cancel the subscription (Using FAKE id)', function () {
    return PayHere::subscription()
        ->cancel('420075032251'); // fake subscription id expect error
})->throws(PayHereException::class);

it('can make payment refund', function () {
    return PayHere::refund()
        ->makePaymentRefund('320027150501') // expect error with FAKE payment_id
        ->note('reason for refund')
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

    expect($client)->toBeInstanceOf(RedirectResponse::class);
});

it('can capture payment', function () {

    $success = <<<'JSON'
        {
            "msg": "Automatic payment charged successfully",
            "data": {
                "order_id": "Order12345",
                "items": "Taxi Hire 123",
                "currency": "LKR",
                "amount": 345.67,
                "custom_1": null,
                "custom_2": null,
                "payment_id": 320025021815,
                "status_code": 2,
                "status_message": "Successfully completed the test tokenized payment.",
                "md5sig": "A098FEBCC06293734641770555B4D569",
                "authorization_token": "74d7f304-7f9d-481d-b47f-6c9cad32d3d5"
            }
        }
    JSON;

    $error = <<<'JSON'
        {
        "error": "invalid_token",
        "error_description": "Invalid access token: e291493a-99a5-4177-9c8b-e8cd18ee9f85"
        }
    JSON;

    Http::fakeSequence()
        ->push(json_decode($success, true))
        ->push(json_decode($error, true));

    $response = PayHere::capture()
        ->usingToken('e34f3059-7b7d-4b62-a57c-784beaa169f4')
        ->amount(100)
        ->reason('reason for capture')
        ->submit();

    assertNotNull($response);

    $response = PayHere::capture()
        ->usingToken('e34f3059-7b7d-4b62-a57c-784beaa169f4')
        ->amount(100)
        ->reason('reason for capture')
        ->submit();

})->throws(PayHereException::class);

it('can generate auth code', function () {
    $ob = new PayHereRestClient();
    $code = 'NE9WeDNhS2hQbzg0SkREU0lvUkg1bjNMSDo4WDZRd3hCMWF2RTRmWGx3RmwzTWZlNHZXNjdLcVZzeko0dVRQakttczh1Yg==';
    expect($ob->generateAuthCode())
        ->toEqual($code);
});

it('can fire accurate events on webhook', function ($webhookKey, $event) {
    Event::fake();

    post('payhere/callback/'.$webhookKey)->assertOk();

    Event::assertDispatched($event);

})
    ->with([
        [Authorize::getCallbackKey(), AuthorizeCallbackEvent::class],
        [Checkout::getCallbackKey(), CheckoutCallbackEvent::class],
        [Recurring::getCallbackKey(), RecurringCallbackEvent::class],
        [PreApproval::getCallbackKey(), PreApprovalCallbackEvent::class],
    ]);
