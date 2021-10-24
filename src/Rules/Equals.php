<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;

class Equals extends AbstractRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * This rule is semantic sugar. You can achieve the
     * same result by using the native 'in' rule, but
     * using 'equals' may make the intention clearer.
     *
     * @param string $attribute.
     * @param mixed $value.
     * @return bool.
     *
     **/
    public function passes($attribute, $value)
    {
        return $this->parameters[0] === $value;
    }

}