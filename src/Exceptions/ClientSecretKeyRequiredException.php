<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class ClientSecretKeyRequiredException extends Exception
{
    public function __construct(
        $message = 'Client secret key is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
