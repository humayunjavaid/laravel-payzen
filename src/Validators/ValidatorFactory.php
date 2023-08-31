<?php
declare(strict_types=1);
namespace Humayunjavaid\Payzen\Validators;

use Humayunjavaid\Payzen\Contracts\Validator;

class ValidatorFactory
{
    public static function createValidator(): Validator
    {
        return new PayzenValidator;
    }
}
