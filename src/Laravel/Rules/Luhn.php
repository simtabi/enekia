<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Vanilla\Validators\Luhn as LuhnValidator;

class Luhn extends AbstractRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new LuhnValidator())->isValid($value);
    }

}
