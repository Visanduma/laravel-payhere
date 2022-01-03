<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 11/26/21
 * Time: 3:03 PM
 */


Route::post("payhere/callback/{type}",[\Lahirulhr\PayHere\Controllers\CallbackController::class,'handle'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
    ->name('payhere.callback');