<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime;

use DateTime;
use Illuminate\Support\Str;

trait Time24Hour
{
    /**
     * @var string
     */
    private $timeSeparator;

    /**
     * @var bool
     */
    protected bool $checkTime24Hour = false;

    /**
     * @param string $timeSeparator
     * @return static
     */
    public function checkTime24Hour(string $timeSeparator = ':'): static
    {
        $this->checkTime24Hour = true;
        $this->timeSeparator   = $timeSeparator;

        return $this;
    }

    public function validateTime24Hour($attribute, $value): bool
    {
        $values = Str::of($value)
            ->replace(' ', '')
            ->explode($this->timeSeparator);

        $expectedFormat = ($values->count() === 2) ? 'H:i' : 'H:i:s';

        $parsedDate = DateTime::createFromFormat(
            $expectedFormat,
            $values->join(':')
        );

        return $parsedDate !== false &&
            Str::of($parsedDate->format($expectedFormat))
                ->matchAll('/'.$values->join('|').'/')
                ->count() === $values->count();
    }

    protected function getTime24HourFormat(): string
    {
        return collect(['20', '00', '00'])->join($this->timeSeparator);
    }

}
