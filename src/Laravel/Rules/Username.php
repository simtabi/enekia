<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRegexRule;

class Username extends AbstractRegexRule implements Rule
{
    /**
     * Pattern for "valid" username
     *  - starts with an letter (alpha)
     *  - only alpha-numeric (a-z, A-Z, 0-9), underscore and minus
     *  - underscores and minus are not allowed at the beginning or end
     *  - multiple underscores and minus are not allowed (-- or _____)
     */
    protected function pattern(): string
    {
        return preg_match('/^[a-z][a-z0-9]*(?:[_\-\.][a-z0-9]+)*$/i', $value);
    }
}
