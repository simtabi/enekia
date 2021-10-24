<?php

declare(strict_types=1);

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;

class Salutation extends AbstractRule implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        $this->setAttribute($attribute);

        return in_array(
            str_replace('.', '', strtolower($value)),
            array_values(pheg()->data()->getSalutations())
        );
    }
}
