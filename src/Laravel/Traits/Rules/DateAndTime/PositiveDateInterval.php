<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime;

use DateInterval;
use Exception;

trait PositiveDateInterval
{

    /**
     * @var bool
     */
    protected bool $checkPositiveDateInterval = false;

    public function checkPositiveDateInterval(): static
    {
        $this->checkPositiveDateInterval  = true;

        return $this;
    }


    /**
     * Checks if the date interval is positive.
     *
     * @param DateInterval $interval
     * @return bool
     */
    private function isPositiveInterval(DateInterval $interval): bool
    {
        return
            // Minus sign for negative interval (more reliable than invert, which can be changed manually)
            $interval->format('%r') !== '-' &&
            // At least one value shouldn't be zero
            $interval->format('P%yY%mM%dDT%hH%iM%sS') !== 'P0Y0M0DT0H0M0S';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function validatePositiveDateInterval($attribute, $value): bool
    {
        if ($value instanceof DateInterval) {
            return $this->isPositiveInterval($value);
        }

        try {
            $dateInterval = new DateInterval($value);

            return $this->isPositiveInterval($dateInterval);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function getMessageKey(): string
    {
        return '';
    }

}
