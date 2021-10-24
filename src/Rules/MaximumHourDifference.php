<?php

namespace Simtabi\Enekia\Rules;

use Carbon\Carbon;
use DateTimeInterface;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;

class MaximumHourDifference extends AbstractRule implements Rule
{
    private DateTimeInterface $date;
    private int $hours;

    public function __construct(DateTimeInterface $date, int $hours = 24)
    {
        $this->date = $date;
        $this->hours = $hours;
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
        try {
            $end = new Carbon($value);
        } catch (Exception $e) {
            return false;
        }

        $diffInMinutes = $end->diffInRealMinutes($this->date);

        return ($diffInMinutes / 60) <= $this->hours;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        return sprintf(
            __('validation::messages.'.$this->shortname()),
            $this->hours
        );
    }

}
