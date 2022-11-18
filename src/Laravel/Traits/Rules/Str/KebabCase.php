<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait KebabCase
{
    protected bool $checkKebabCase = false;

    public function checkIfIsKebabCase(): static
    {
        $this->checkKebabCase = true;

        return $this;
    }

    public function validateKebabCase($attribute, $value): bool
    {
        return (bool) preg_match("/^(?:\p{Ll}+\-)*\p{Ll}+$/u", $value);
    }

}
