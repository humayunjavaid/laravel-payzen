<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class CHallanNumberRequiredException extends Exception
{
    public function __construct(
        $message = 'Challan number is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
