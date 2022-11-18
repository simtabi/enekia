<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Traits\Rules\Banking;

trait MonetaryFigure
{

    protected bool $checkMonetaryFigure = false;

    public function checkMonetaryFigure(): static
    {
        $this->checkMonetaryFigure = true;

        return $this;
    }

    /**
     * Generate an example value that satisfies the validation rule.
     *
     **/
    public function example() : string
    {
        return $this->parameters[0] .
               mt_rand(1, (int) str_repeat('9', $this->parameters[1])) . '.' .
               mt_rand(1, (int) str_repeat('9', $this->parameters[2]));
    }

    /**
     * Determine if the validation rule passes.
     *
     * The monetary figure requires three parameters:
     * 1. The currency symbol required e.g. '$', '£', '€'.
     * 2. The maximum number of digits before the decimal point.
     * 3. The maximum number of digits after the decimal point.
     *
     **/
    public function validateMonetaryFigure($attribute, $value) : bool
    {
        return preg_match(
            "/^\\{$this->parameters[0]}[0-9]{1,{$this->parameters[1]}}(\.[0-9]{1,{$this->parameters[2]}})?$/",
            $value
        ) > 0;
    }

}
