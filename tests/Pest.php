<?php

use Illuminate\Support\Facades\Config;
use Lahirulhr\PayHere\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

beforeEach(function () {
    Config::set('payhere.api_endpoint', 'https://sandbox.payhere.lk/');
    Config::set('payhere.app_id', '');
    Config::set('payhere.app_secret', '');
});
