<?php

namespace Lahirulhr\PayHere\Api;

use Lahirulhr\PayHere\Helpers\PayHereRestClient;

class Refund extends PayHereRestClient
{
    protected $url = 'merchant/v1/payment/refund';

    public function makePaymentRefund(string $payment_id)
    {
        $this->form_data['payment_id'] = $payment_id;

        return $this;
    }

    public function makePaymentAuthorizationRefund(string $authorization_token)
    {
        $this->form_data['authorization_token'] = $authorization_token;

        return $this;
    }

    public function note(string $note)
    {
        $this->form_data['description'] = $note;

        return $this;
    }
}
