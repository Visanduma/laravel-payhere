<?php

namespace Lahirulhr\PayHere\Api;

use Lahirulhr\PayHere\Helpers\PayHereRestClient;

class Subscription extends PayHereRestClient
{
    public function getAll()
    {
        $this->method = 'get';
        $this->url = 'merchant/v1/subscription';

        return $this->submit();
    }

    public function getPaymentsOfSubscription(string $subscription_id)
    {
        $this->method = 'get';
        $this->url = "merchant/v1/subscription/$subscription_id/payments";

        return $this->submit();
    }

    public function retry(string $subscription_id)
    {
        $this->method = 'post';
        $this->url = 'merchant/v1/subscription/retry';
        $this->form_data['subscription_id'] = $subscription_id;

        return $this->submit();
    }

    public function cancel(string $subscription_id)
    {
        $this->method = 'post';
        $this->url = 'merchant/v1/subscription/cancel';
        $this->form_data['subscription_id'] = $subscription_id;

        return $this->submit();
    }
}
