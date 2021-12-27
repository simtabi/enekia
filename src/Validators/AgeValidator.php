<?php declare(strict_types=1);

namespace Simtabi\Enekia\Validators;

use Simtabi\Enekia\Validators\Traits\WithRespectValidationTrait;

class AgeValidator
{

    use WithRespectValidationTrait;

    public function isLegalAge($value, $limit = 18): bool
    {
        if($this->respect()->age($limit)->validate($value)){
            return true;
        }
        return false;
    }

}