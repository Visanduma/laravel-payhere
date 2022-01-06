<?php

namespace Lahirulhr\PayHere\Tests;

use Illuminate\Support\Facades\Event;
use Lahirulhr\PayHere\Api\Checkout;
use Lahirulhr\PayHere\Events\CheckoutCallbackEvent;

class EventTest extends TestCase
{
    public function test_ableToEmitCallbackEvent()
    {
        Event::fake();

        $this->post(route('payhere.callback', Checkout::getCallbackKey()), [
            'f1' => 'v1',
            'f2' => 'v2',
        ]);

        Event::assertDispatched(CheckoutCallbackEvent::class);
    }
}
