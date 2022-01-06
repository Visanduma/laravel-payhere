<?php

namespace Lahirulhr\PayHere\Helpers;

class PayHereClient
{
    protected $url;
    protected $required_data = [];
    protected $optional_data = [];
    protected $success_url;
    protected $fail_url;
    protected $notify_url;

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

    private function setNotifyUrl()
    {
        $this->notify_url = route('payhere.callback', $this->getCallbackKey());
    }

    public function setOptionalData($data)
    {
        $this->optional_data = $data;
    }

    private function authData()
    {
        return [
            'merchant_id' => config('payhere.merchant_id'),
            'return_url' => $this->success_url,
            'cancel_url' => $this->fail_url,
            'notify_url' => $this->notify_url,
        ];
    }

    public function getFormData()
    {
        $this->setNotifyUrl();

        return array_merge($this->authData(), $this->required_data, $this->optional_data);
    }

    public function getFullApiUrl()
    {
        return  config('payhere.api_endpoint') . $this->url;
    }

    public function renderView()
    {
        $action = $this->getFullApiUrl();
        $data = $this->getFormData();

        return view("payhere::recurring", compact('action', 'data'));
    }

    public static function getCallbackKey()
    {
        return base64_encode(get_called_class());
    }
}
