<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime;

use DateInterval;
use Exception;

trait Interval
{

    /**
     * @var bool
     */
    protected bool $checkIfIsInterval = false;

    public function checkIfIsInterval(): static
    {
        $this->checkIfIsInterval  = true;

        return $this;
    }

    public function validateInterval($attribute, $value): bool
    {
        // Empty string means 0 interval
        if ($value === '') {
            $value = 'P0Y';
        }
        
        try {
            new DateInterval($value);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
