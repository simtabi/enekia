<?php

namespace Simtabi\Enekia\Vanilla\Validators;

use Simtabi\Enekia\Laravel\Validators\CreditCards\Supports\LuhnValidator;

class Luhn
{

    public function __construct(){}

    public function isValid($value): bool
    {
        return LuhnValidator::checksumIsValid(LuhnValidator::getChecksum($value));
    }

}