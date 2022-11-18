<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait SnakeCase
{
    protected bool $checkIfIsSnakeCase = false;

    public function checkIfIsSnakeCase(): static
    {
        $this->checkIfIsSnakeCase = true;

        return $this;
    }

    public function validateSnakeCase($attribute, $value): bool
    {
        return (bool) preg_match("/^(?:\p{Ll}+_)*\p{Ll}+$/u", $value);
    }

}
