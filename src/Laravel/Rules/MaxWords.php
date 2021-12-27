<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;

class MaxWords extends AbstractRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        return count(preg_split('~[^\p{L}\p{N}\']+~u', $value)) <= $this->parameters[0];
    }

}