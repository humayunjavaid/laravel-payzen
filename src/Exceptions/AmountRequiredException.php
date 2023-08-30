<?php

namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class AmountRequiredException extends Exception
{
    public function __construct(
        $message = 'Amount is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
