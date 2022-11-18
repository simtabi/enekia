<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class DutchPostalCode extends AbstractRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match('/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i', $value) != false;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function getMessageKey(): string|null|array
    {
        return 'dutch_postal_code';
    }
}
