<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 11/26/21
 * Time: 3:09 PM
 */

namespace Lahirulhr\PayHere\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lahirulhr\PayHere\Api\Authorize;
use Lahirulhr\PayHere\Events\AuthorizeCallbackEvent;

class CallbackController extends Controller
{
    public function handle($type,Request $request)
    {
        switch ($type){
            case Authorize::callbackKey():
                // emit event
                event(new AuthorizeCallbackEvent($request->all()));
                break;

            case "test":
                // emit event two
                break;
        }

    }
}