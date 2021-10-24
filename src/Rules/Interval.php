<?php

namespace Simtabi\Enekia\Rules;

use DateInterval;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;

class Interval extends AbstractRule implements Rule
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
        // Empty string means 0 interval
        if ($value === '') {
            $value = 'P0Y';
        }

        try {
            new DateInterval($value);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
