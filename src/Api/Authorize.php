<?php

namespace Lahirulhr\PayHere\Api;

use Lahirulhr\PayHere\Helpers\PayHereClient;

class Authorize extends PayHereClient
{
    protected $url = 'pay/authorize';
}
