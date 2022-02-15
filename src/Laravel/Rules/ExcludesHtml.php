<?php

namespace Simtabi\Enekia\Laravel\Rules;

use function strip_tags;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;

class ExcludesHtml extends AbstractRule implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        return strip_tags((string) $value) === $value;
    }
}