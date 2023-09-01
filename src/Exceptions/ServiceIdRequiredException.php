<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class ServiceIdRequiredException extends Exception
{
    public function __construct(
        $message = 'Service id is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
