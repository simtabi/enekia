<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class Enum extends AbstractRule implements Rule
{
    protected string $enumClass;

    public function __construct(string $enumClass)
    {
        $this->enumClass = $enumClass;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $enum = $this->enumClass::tryFrom($value);
            return $enum instanceof $this->enumClass;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function getMessageKey(): string|null|array
    {
        return 'enum';
    }
}