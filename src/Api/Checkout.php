<?php

namespace Lahirulhr\PayHere\Api;

use Illuminate\Support\Facades\Http;
use Lahirulhr\PayHere\Helpers\PayHereClient;

class Checkout extends PayHereClient
{
    protected $url = "pay/checkout";

}
