<?php

namespace Simtabi\Enekia\Rules;

use Simtabi\Enekia\AbstractRule;

class Domain extends AbstractRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        return preg_match('/^([\w-]+\.)*[\w\-]+\.\w{2,10}$/', $value) > 0;
    }
}