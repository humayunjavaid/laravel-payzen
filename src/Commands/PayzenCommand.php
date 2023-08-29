<?php

namespace Humayunjavaid\Payzen\Commands;

use Illuminate\Console\Command;

class PayzenCommand extends Command
{
    public $signature = 'laravel-payzen';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
