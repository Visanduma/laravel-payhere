<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 11/26/21
 * Time: 4:03 PM
 */

namespace Lahirulhr\PayHere\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuthorizeCallbackEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }
}