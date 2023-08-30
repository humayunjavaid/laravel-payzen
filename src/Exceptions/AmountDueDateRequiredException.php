<?php

namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class AmountDueDateRequiredException extends Exception
{
    public function __construct(
        $message = 'Amount Due Date is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
