<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime;

use Carbon\Carbon;
use DateTimeInterface;
use Exception;

trait MaximumHourDifference
{
    private DateTimeInterface $date;
    private int $hours;

    /**
     * @var bool
     */
    protected bool $checkMaximumHourDifference = false;

    public function checkMaximumHourDifference(DateTimeInterface $date, int $hours = 24): static
    {
        $this->checkMaximumHourDifference = true;
        $this->date                       = $date;
        $this->hours                      = $hours;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function validateMaximumHourDifference($attribute, $value): bool
    {
        try {
            $end = new Carbon($value);
        } catch (Exception $e) {
            return false;
        }

        $diffInMinutes = $end->diffInRealMinutes($this->date);

        return ($diffInMinutes / 60) <= $this->hours;
    }

}
