<?php declare(strict_types=1);

namespace Simtabi\Enekia\Validators;

use Simtabi\Enekia\Validators\Traits\WithInstanceTrait;
use Simtabi\Enekia\Validators\Traits\WithRespectValidationTrait;

class Age
{

    use WithRespectValidationTrait;
    use WithInstanceTrait;

    public function isLegalAge($value, $limit = 18): bool
    {
        if($this->respect()->age($limit)->validate($value)){
            return true;
        }
        return false;
    }

}