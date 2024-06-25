<?php

namespace Lahirulhr\PayHere\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Lahirulhr\PayHere\Exceptions\PayHereException;

class PayHereRestClient
{
    protected $url;

    protected $form_data = [];

    protected $method = 'post';

    public function withData(array $data)
    {
        $this->form_data = $data;

        return $this;
    }

    public function getAccessToken()
    {
        $url = $this->apiUrl('merchant/v1/oauth/token');

        $data = Http::asForm()
            ->withToken($this->generateAuthCode(), 'Basic')
            ->post($url, [
                'grant_type' => 'client_credentials',
            ]);

        return $data->json()['access_token'] ?? null;
    }

    public function generateAuthCode()
    {
        return base64_encode(config('payhere.app_id').':'.config('payhere.app_secret'));
    }

    public function cachedAccessToken()
    {
        return Cache::remember('payhere-access-token', now()->addDays(7), function () {
            return $this->getAccessToken();
        });
    }

    public function generateHash($orderId, $amount, $currency = 'LKR')
    {
        return strtoupper(
            md5(
                config('payhere.merchant_id').
                    $orderId.
                    number_format($amount, 2, '.', '').
                    $currency.
                    strtoupper(md5(config('payhere.merchant_secret')))
            )
        );
    }

    /**
     * @throws PayHereException
     */
    public function submit()
    {
        if ($this->method == 'post') {
            $client = Http::asJson()
                ->withToken($this->cachedAccessToken())
                ->post($this->apiUrl($this->url), $this->form_data);
        } else {
            $client = Http::withToken($this->cachedAccessToken())
                ->get($this->apiUrl($this->url), $this->form_data);
        }

        $output = $client->json();

        if (! $output) {
            throw new PayHereException('No data from API !');
        }

        if (array_key_exists('error', $output)) {
            throw new PayHereException($output['error_description']);
        }

        if (array_key_exists('status', $output) && $output['status'] < 0) {
            throw new PayHereException($output['msg']);
        }

        return $output;
    }

    private function apiUrl($path = '')
    {
        return str(config('payhere.api_endpoint'))
            ->finish('/')
            ->append($path)
            ->toString();
    }
}
