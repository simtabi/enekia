<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait UpperCase
{
    protected bool $checkIfIsUpperCase = false;

    public function checkIfIsUpperCase(): static
    {
        $this->checkIfIsUpperCase = true;

        return $this;
    }

    public function validateUpperCase($attribute, $value): bool
    {
        return $value === (mb_strtoupper($value, mb_detect_encoding($value)));
    }

}
