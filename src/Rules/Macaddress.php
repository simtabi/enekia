<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRegexRule;

class Macaddress extends AbstractRegexRule implements Rule
{
    protected function pattern(): string
    {
        return "/^[0-9a-f]{12}$/i";
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return parent::passes($attribute, preg_replace("/[\. :-]/i", '', $value));
    }
}
