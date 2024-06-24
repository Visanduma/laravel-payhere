<?php

namespace Lahirulhr\PayHere\Exceptions;

use Exception;

class PayHereException extends Exception
{
    public function render($request)
    {
        return response()->json(['error' => true, 'message' => $this->getMessage()]);
    }
}
