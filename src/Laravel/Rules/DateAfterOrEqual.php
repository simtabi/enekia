<?php

namespace Simtabi\Enekia\Laravel\Rules;

use DateTimeInterface;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;

class DateAfterOrEqual extends AbstractRule implements Rule
{
    private DateTimeInterface $date;

    public function __construct(DateTimeInterface $date)
    {
        $this->date = $date;
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
        $limitTimestamp = $this
            ->date
            ->getTimestamp();

        return strtotime($value) >= $limitTimestamp;
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
            $this->date->toIso8601String()
        );
    }
}
