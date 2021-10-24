<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;

class Base64EncodedString extends AbstractRule implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        $this->setAttribute($attribute);

        $decoded = base64_decode($value, true);

        if ($decoded === false) {
            return false;
        }

        if ($value !== base64_encode($decoded)) {
            return false;
        }

        // false positives are possible, finally validate the expected characters ...
        return preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $value) === 1;
    }
}