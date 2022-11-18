<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Banking;

trait BicNumber
{

    /**
     * @var bool
     */
    protected bool $checkBicNumber = false;

    public function checkBicNumber(): static
    {
        $this->checkBicNumber = true;

        return $this;
    }

    public function validateBicNumber($attribute, $value): bool
    {
        return (bool) preg_match("/^[A-Za-z]{4} ?[A-Za-z]{2} ?[A-Za-z0-9]{2} ?([A-Za-z0-9]{3})?$/", $value);
    }

}
