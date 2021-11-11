<?php

namespace Lahirulhr\PayHere\Helpers;

use Illuminate\Support\Facades\Http;
use Lahirulhr\PayHere\Exceptions\PayHereException;

class PayHereClient
{
    protected $url;
    protected $required_data = [];
    protected $optional_data = [];
    protected $success_url;
    protected $fail_url;
    protected $notify_url;

    public function submit()
    {
        $formData = array_merge($this->authData(), $this->required_data, $this->optional_data);

        $client = Http::asForm()
            ->post(config('payhere.api_endpoint').$this->url, $formData);

        if (! $client->body()) {
            throw new PayHereException();
        } else {
            return $client;
        }
    }

    public function data(array $array)
    {
        $this->required_data = $array;

        return $this;
    }

    public function successUrl($url)
    {
        $this->success_url = $url;

        return $this;
    }

    public function failUrl($url)
    {
        $this->fail_url = $url;

        return $this;
    }

    private function authData()
    {
        return [
            'merchant_id' => config('payhere.merchant_id'),
            'return_url' => $this->success_url,
            'cancel_url' => $this->fail_url,
            'notify_url' => $this->notify_url ?? 'www.visanduma.com/notify',
        ];
    }
}
