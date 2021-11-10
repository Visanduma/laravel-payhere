<?php

namespace Lahirulhr\PayHere;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lahirulhr\PayHere\PayHere
 */
class PayHereFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-payhere';
    }
}
