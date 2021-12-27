<?php

declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;

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
