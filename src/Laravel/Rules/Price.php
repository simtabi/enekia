<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;

class Price extends AbstractRule implements Rule
{
    /**
     * Holds the required decimal notation. Null to not limit to a specific decimal sign.
     */
    private ?string $decimalSign;

    public function __construct(string $decimalSign = null)
    {
        $this->decimalSign = $decimalSign;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $requiresDecimals = !is_null($this->decimalSign);
        if (is_null($this->decimalSign)) {
            $decimalSign = '(,|\.)?';
        } else {
            $decimalSign = '(' . ($this->decimalSign === '.' ? '\.' : $this->decimalSign) . ')';
        }

        $pattern = sprintf(
            '/[\d]{1,}%s[\d|\-]{%d,}/',
            $decimalSign,
            $requiresDecimals ? 1 : 0
        );

        return preg_match($pattern, $value) != false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        if (is_null($this->decimalSign)) {
            return __('ekenia::messages.'.$this->shortname() . '.base');
        }

        return sprintf(
            __('ekenia::messages.'.$this->shortname() . '.custom_decimal'),
            $this->decimalSign
        );
    }

}
