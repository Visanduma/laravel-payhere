<?php

namespace Lahirulhr\PayHere\Api;

use Lahirulhr\PayHere\Helpers\PayHereRestClient;

class Retrieve extends PayHereRestClient
{
    protected $url = 'merchant/v1/payment/search?order_id=';

    protected $method = 'get';

    public function orderId($order_id)
    {
        $this->url = $this->url.trim($order_id);

        return $this;
    }
}
