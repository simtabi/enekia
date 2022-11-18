<?php

namespace Simtabi\Enekia\Laravel\Rules;

/**
 * The field under validation must contain ASCII chars only.
 *
 * @package Simtabi\Enekia\Laravel\Rules
 */
trait ASCII
{
    protected bool $checkIfHasASCII = false;

    public function checkIfHasASCII(): static
    {
        $this->checkIfHasASCII = true;

        return $this;
    }

    public function validateASCII($attribute, $value): bool
    {
        return (bool) preg_match('/^[\x00-\x7F]+$/', $value);
    }

    public function __construct()
    {
        parent::__construct();
    }
}
