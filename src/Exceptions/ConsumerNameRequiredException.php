<?php

namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class ConsumerNameRequiredException extends Exception
{
    public function __construct(
        $message = 'Consumer Name is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}
