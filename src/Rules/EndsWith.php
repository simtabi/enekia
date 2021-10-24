<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;
use Str;

class EndsWith extends AbstractRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * The rule has one parameter:
     * 1. The string the value must end with.
     *
     * @param string $attribute.
     * @param mixed $value.
     * @return bool.
     *
     **/
    public function passes($attribute, $value)
    {
        return Str::endsWith($value, $this->parameters[0]);
    }

}