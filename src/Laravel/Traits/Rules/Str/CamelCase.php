<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait CamelCase
{

    protected bool $checkCamelCase = false;

    public function checkIfIsCamelCase(): static
    {
        $this->checkCamelCase = true;

        return $this;
    }

    public function validateCamelCase($attribute, $value): bool
    {
        return (bool) preg_match("/^(?:\p{Lu}?\p{Ll}+)(?:\p{Lu}\p{Ll}+)*$/u", $value);
    }
}
