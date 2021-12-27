<?php declare(strict_types=1);

namespace Simtabi\Enekia\Validators;

use Simtabi\Enekia\Validators\Traits\WithRespectValidationTrait;

class PostalCodeValidator
{

    use WithRespectValidationTrait;

    public function isPostalCode($value, $locale = 'US'): bool
    {
        if($this->respect()->numeric()->postalCode($locale)->validate($value)){
            return true;
        }
        return false;
    }

}