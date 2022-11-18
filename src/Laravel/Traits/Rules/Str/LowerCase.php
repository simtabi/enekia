<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait LowerCase
{

    protected bool $checkIfIsLowerCase = false;

    public function checkIfIsLowerCase(): static
    {
        $this->checkIfIsLowerCase = true;

        return $this;
    }

    public function validateLowerCase($attribute, $value): bool
    {
        return $value === (mb_strtolower($value, mb_detect_encoding($value)));
    }

}
