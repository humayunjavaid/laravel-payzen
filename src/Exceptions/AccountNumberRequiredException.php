<?php
declare(strict_types=1);
namespace Humayunjavaid\Payzen\Exceptions;

use Exception;
use Throwable;

class AccountNumberRequiredException extends Exception
{
    public function __construct(
        $message = 'Account number is required.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
