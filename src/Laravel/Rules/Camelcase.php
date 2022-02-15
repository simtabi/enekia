<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRegexRule;

class Camelcase extends AbstractRegexRule implements Rule
{
    protected function pattern(): string
    {
        return "/^(?:\p{Lu}?\p{Ll}+)(?:\p{Lu}\p{Ll}+)*$/u";
    }
}
