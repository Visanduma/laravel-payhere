<?php

namespace Lahirulhr\PayHere\Helpers;

use Illuminate\Support\Facades\Http;

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

        return Http::asForm()
            ->post(config('payhere.api_endpoint').$this->url, $formData);
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

    public function getAccessToken()
    {
        $url = config('payhere.api_endpoint')."merchant/v1/oauth/token";
        $data = Http::asForm()->withToken(config('payhere.auth_code'), 'Basic')
            ->post($url, [
                'grant_type' => 'client_credentials',
            ]);

        return $data->json();
    }
}
