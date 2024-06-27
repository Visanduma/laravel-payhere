<?php

namespace Lahirulhr\PayHere\Controllers;

use Illuminate\Http\Request;

class FormController {

    public function __invoke(Request $request)
    {
        $payload = decrypt($request->get('payload'));

        return view('payhere::recurring', [
            'action' => $payload['action'],
            'data' => $payload['data'],
        ]);
    }
}
