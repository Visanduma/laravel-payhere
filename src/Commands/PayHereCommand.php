<?php

namespace Lahirulhr\PayHere\Commands;

use Illuminate\Console\Command;

class PayHereCommand extends Command
{
    public $signature = 'laravel-payhere';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
