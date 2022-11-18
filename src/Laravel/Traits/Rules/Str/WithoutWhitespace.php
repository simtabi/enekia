<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait WithoutWhitespace
{
    protected bool $checkIfIsWithoutWhitespace = false;

    public function checkIfIsWithoutWhitespace(): static
    {
        $this->checkIfIsWithoutWhitespace = true;

        return $this;
    }

    public function validateWithoutWhitespace($attribute, $value): bool
    {
        return (preg_match('/\s/', $value) === 0) || preg_match('/^\S*$/u', $value);
    }
}
