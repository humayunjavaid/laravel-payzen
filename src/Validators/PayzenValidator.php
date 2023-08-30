<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen\Validators;

use Humayunjavaid\Payzen\Contracts\Validator;
use Humayunjavaid\Payzen\Exceptions\ConsumerNameRequiredException;

class PayzenValidator implements Validator
{
    public function validate(array $arguments): void
    {
        if (empty($arguments['consumerName'])) {
            throw new ConsumerNameRequiredException;
        }
    }

}
