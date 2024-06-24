<?php

namespace Lahirulhr\PayHere\Api;

use Lahirulhr\PayHere\Helpers\PayHereClient;

class Checkout extends PayHereClient
{
    protected $url = 'pay/checkout';
}
