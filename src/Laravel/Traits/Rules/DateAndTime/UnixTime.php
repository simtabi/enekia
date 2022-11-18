<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime;

use DateTime;

trait UnixTime
{

    /**
     * @var bool
     */
    protected bool $checkUnixTime = false;

    /**
     * @return static
     */
    public function checkUnixTime(): static
    {
        $this->checkUnixTime = true;

        return $this;
    }

    public function validateUnixTime($attribute, $value): bool
    {
        if (! is_numeric($value)) {
            return false;
        }

        $dateTime = DateTime::createFromFormat('U', (string) $value);

        return $dateTime !== false;
    }

}
