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
use Lahirulhr\PayHere\Api\Checkout;
use Lahirulhr\PayHere\Api\PreApproval;
use Lahirulhr\PayHere\Api\Recurring;
use Lahirulhr\PayHere\Events\AuthorizeCallbackEvent;
use Lahirulhr\PayHere\Events\CheckoutCallbackEvent;
use Lahirulhr\PayHere\Events\PreApprovalCallbackEvent;
use Lahirulhr\PayHere\Events\RecurringCallbackEvent;

class CallbackController extends Controller
{
    public function handle($type, Request $request)
    {
        switch ($type) {
            case Authorize::getCallbackKey():
                event(new AuthorizeCallbackEvent($request->all()));

                break;

            case Checkout::getCallbackKey():
                event(new CheckoutCallbackEvent($request->all()));

                break;

            case Recurring::getCallbackKey():
                event(new RecurringCallbackEvent($request->all()));

                break;

            case PreApproval::getCallbackKey():
                event(new PreApprovalCallbackEvent($request->all()));

                break;

        }
    }
}
