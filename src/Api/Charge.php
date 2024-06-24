<?php

namespace Lahirulhr\PayHere\Api;

use Lahirulhr\PayHere\Helpers\PayHereRestClient;

class Charge extends PayHereRestClient
{
    protected $url = 'merchant/v1/payment/charge';

    public function byToken($token)
    {
        $this->form_data['customer_token'] = $token;

        return $this;
    }
}
