<?php

namespace Lahirulhr\PayHere\Api;

use Lahirulhr\PayHere\Helpers\PayHereRestClient;

class Capture extends PayHereRestClient
{
    protected $url = 'merchant/v1/payment/capture';

    public function usingToken(string $authorization_token)
    {
        $this->form_data['authorization_token'] = $authorization_token;

        return $this;
    }

    public function amount(float $amount)
    {
        $this->form_data['amount'] = $amount;

        return $this;
    }

    public function reason(string $reason = '')
    {
        $this->form_data['deduction_details'] = $reason;

        return $this;
    }
}
