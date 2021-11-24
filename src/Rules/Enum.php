<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;

class Enum extends AbstractRule implements Rule
{
    /** @var array */
    protected $validValues;

    public function __construct(string $enumClass)
    {
        $this->validValues = array_keys($enumClass::toArray());
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        return in_array($value, $this->validValues);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        $validValues = implode(', ', $this->validValues);

        return __('ekenia::messages.enum', [
            'validValues' => $validValues,
            'attribute'   => $this->attribute,
        ]);
    }

}