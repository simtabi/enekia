<?php

declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class Salutation extends AbstractRule implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return in_array(str_replace('.', '', strtolower($value)), array_values(pheg()->supports()->getSalutations()));
    }


    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return 'salutation';
    }
}
