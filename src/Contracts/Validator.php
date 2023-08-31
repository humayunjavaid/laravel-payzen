<?php
declare(strict_types=1);
namespace Humayunjavaid\Payzen\Contracts;

interface Validator
{
    public function validate(array $arguments);

    public function getValidatedData();
}
