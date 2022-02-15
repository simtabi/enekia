<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Simtabi\Enekia\Laravel\AbstractRule;

class NotContains extends AbstractRule implements Rule
{
    private string $needle;

    public function __construct(string $needle = '')
    {
        $this->needle = $needle;
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
        if ($this->needle === '') {
            return true;
        }

        return ! Str::contains($value, $this->needle);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        return sprintf(
            __('ekenia::messages.'.$this->shortname()),
            $this->needle
        );
    }

}
