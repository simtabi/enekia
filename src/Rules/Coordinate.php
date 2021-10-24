<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;
use function preg_match;

class Coordinate extends AbstractRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     * Validates a lat/lng co ordinate like "47.1,179.1".
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $this->setAttribute($attribute);

        $parts = explode(',', $value);

        if ($parts === [] || ! isset($parts[1])) {
            return false;
        }

        return preg_match(
                '/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/',
                trim($parts[0]).','.trim($parts[1])
            ) !== 0;
    }
}