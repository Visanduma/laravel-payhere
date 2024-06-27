<?php

use Illuminate\Support\Facades\Route;
use Lahirulhr\PayHere\Controllers\FormController;

Route::post('payhere/callback/{type}', [\Lahirulhr\PayHere\Controllers\CallbackController::class, 'handle'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
    ->name('payhere.callback');

Route::get('payhere/form', FormController::class);
