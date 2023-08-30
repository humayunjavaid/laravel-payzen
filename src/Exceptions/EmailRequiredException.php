<?php

namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class EmailRequiredException extends Exception
{
    public function __construct(
        $message = 'Account number is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}
