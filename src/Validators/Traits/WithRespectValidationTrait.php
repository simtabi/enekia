<?php

namespace Simtabi\Enekia\Validators\Traits;

use Respect\Validation\Validator as Respect;

trait WithRespectValidationTrait
{

    public function respect(): Respect
    {
        return new Respect();
    }

}