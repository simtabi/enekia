<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Banking;

trait Price
{

    /**
     * Holds the required decimal notation. Null to not limit to a specific decimal sign.
     */
    private ?string $decimalSign = null;

    protected bool $checkPrice = false;

    public function checkPrice(?string $decimalSign = null): static
    {
        $this->checkPrice  = true;
        $this->decimalSign = $decimalSign;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function validatePrice($attribute, $value): bool
    {
        $requiresDecimals = !is_null($this->decimalSign);
        if (is_null($this->decimalSign)) {
            $decimalSign  = '(,|\.)?';
        } else {
            $decimalSign  = '(' . ($this->decimalSign === '.' ? '\.' : $this->decimalSign) . ')';
        }

        $pattern = sprintf(
            '/[\d]{1,}%s[\d|\-]{%d,}/',
            $decimalSign,
            $requiresDecimals ? 1 : 0
        );

        return preg_match($pattern, $value) != false;
    }

}
