<?php

namespace Lahirulhr\PayHere;

use Illuminate\Support\Facades\Http;
use Lahirulhr\PayHere\Api\Checkout;
use Lahirulhr\PayHere\Api\PreApproval;
use Lahirulhr\PayHere\Api\Subscription;

class PayHere
{
    public static function checkOut(): Checkout
    {
        return new Checkout();
   }

    public static function subscription(): Subscription
    {
        return new Subscription();
    }

    public static function preapproval(): PreApproval
    {
        return new PreApproval();
    }
}
