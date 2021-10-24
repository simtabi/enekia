<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;

class Uppercase extends AbstractRule implements Rule
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

        if (! is_string($value)) {
            return false;
        }

        return $value === $this->getUpperCaseValue($value);
    }

    /**
     * Return value as uppercase
     *
     * @return string
     */
    private function getUpperCaseValue($value): string
    {
        return mb_strtoupper($value, mb_detect_encoding($value));
    }
}
