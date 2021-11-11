<?php

namespace Lahirulhr\PayHere\Helpers;

use Illuminate\Support\Facades\Http;
use Lahirulhr\PayHere\Exceptions\PayHereException;

class PayHereRestClient
{
    protected $url;
    protected $form_data = [];
    protected $method = "post";

    public function withData(array $data)
    {
       $this->form_data = $data;
       return $this;

    }

    public function getAccessToken()
    {
        $url = config('payhere.api_endpoint')."merchant/v1/oauth/token";
        $data =  Http::asForm()->withToken(config('payhere.auth_code'),'Basic')
            ->post($url,[
                'grant_type' => 'client_credentials'
            ]);

        return $data->json()['access_token'] ?? null;
    }

    /**
     * @throws PayHereException
     */

    public function submit()
    {
        if($this->method == "post"){
            $client = Http::asJson()
                ->withToken($this->getAccessToken())
                ->post(config('payhere.api_endpoint').$this->url,$this->form_data);
        }else{
            $client = Http::withToken($this->getAccessToken())
                ->get(config('payhere.api_endpoint').$this->url,$this->form_data);
        }


        $output = $client->json();

        if($output && $output['status'] < 0){
            throw new PayHereException($output['msg']);
        }else{
            return $output;
        }


    }
}