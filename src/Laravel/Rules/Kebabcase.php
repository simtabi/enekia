<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRegexRule;

class Kebabcase extends AbstractRegexRule implements Rule
{
    protected function pattern(): string
    {
        return "/^(?:\p{Ll}+\-)*\p{Ll}+$/u";
    }
}
