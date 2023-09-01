<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen\Validators;

use Humayunjavaid\Payzen\Contracts\Validator;
use Humayunjavaid\Payzen\Exceptions\AmountAfterDueDateRequiredException;
use Humayunjavaid\Payzen\Exceptions\AmountWithinDueDateRequiredException;
use Humayunjavaid\Payzen\Exceptions\ChallanNumberRequiredException;
use Humayunjavaid\Payzen\Exceptions\ConsumerNameRequiredException;
use Humayunjavaid\Payzen\Exceptions\DueDateRequiredException;
use Humayunjavaid\Payzen\Exceptions\ExpiryDateRequiredException;
use Humayunjavaid\Payzen\Exceptions\ServiceIdRequiredException;

class PayzenValidator implements Validator
{
    protected array $validatedData = [];

    public function validate(array $arguments): void
    {

        if (empty($arguments['consumerName'])) {
            throw new ConsumerNameRequiredException;
        }

        if (empty($arguments['challanNumber'])) {
            throw new ChallanNumberRequiredException;
        }

        if (empty($arguments['serviceId'])) {
            throw new ServiceIdRequiredException;
        }

        if (empty($arguments['dueDate'])) {
            throw new DueDateRequiredException;
        }

        if (empty($arguments['expiryDate'])) {
            throw new ExpiryDateRequiredException;
        }

        if (empty($arguments['amountWithinDueDate'])) {
            throw new AmountWithinDueDateRequiredException;
        }

        if (empty($arguments['amountAfterDueDate'])) {
            throw new AmountAfterDueDateRequiredException;
        }

        $this->validatedData = $arguments;
    }

    public function getValidatedData(): array
    {
        return $this->validatedData;

    }
}
