<?php

namespace Lahirulhr\PayHere;

use Lahirulhr\PayHere\Api\Authorize;
use Lahirulhr\PayHere\Api\Capture;
use Lahirulhr\PayHere\Api\Charge;
use Lahirulhr\PayHere\Api\Checkout;
use Lahirulhr\PayHere\Api\PreApproval;
use Lahirulhr\PayHere\Api\Recurring;
use Lahirulhr\PayHere\Api\Refund;
use Lahirulhr\PayHere\Api\Retrieve;
use Lahirulhr\PayHere\Api\Subscription;

class PayHere
{
    public static function checkOut(): Checkout
    {
        return new Checkout();
    }

    public static function recurring(): Recurring
    {
        return new Recurring();
    }

    public static function preapproval(): PreApproval
    {
        return new PreApproval();
    }

    public static function charge(): Charge
    {
        return new Charge();
    }

    public static function retrieve(): Retrieve
    {
        return new Retrieve();
    }

    public static function subscription(): Subscription
    {
        return new Subscription();
    }

    public static function refund(): Refund
    {
        return new Refund();
    }

    public static function authorize(): Authorize
    {
        return new Authorize();
    }

    public static function capture(): Capture
    {
        return new Capture();
    }
}
