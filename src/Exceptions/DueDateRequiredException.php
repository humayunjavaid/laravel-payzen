<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class DueDateRequiredException extends Exception
{
    public function __construct(
        $message = 'Due Date is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
