<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Vanilla\Validators\Luhn;

class Imei extends AbstractRule implements Rule
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
        return $this->hasValidLength($value) && (new Luhn())->isValid($value);
    }

    /**
     * Determine if current value has valid IMEI length
     *
     * @param $value
     * @return boolean
     */
    private function hasValidLength($value): bool
    {
        return strlen($value) === 15;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return 'imei';
    }
}
