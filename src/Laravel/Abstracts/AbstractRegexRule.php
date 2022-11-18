<?php

namespace Simtabi\Enekia\Laravel\Abstracts;

abstract class AbstractRegexRule extends AbstractRule
{
    /**
     * REGEX pattern of rule
     */
    abstract protected function pattern(): string;

    public function __construct()
    {
        $this->parameters = func_get_args();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (bool) preg_match($this->pattern(), $value);
    }
}
