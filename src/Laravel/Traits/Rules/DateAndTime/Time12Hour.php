<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime;

use DateTime;
use Illuminate\Support\Str;

trait Time12Hour
{
    /**
     * @var string
     */
    private $timeSeparator;

    /**
     * @var bool
     */
    private $requiresMeridiem;

    /**
     * @var bool
     */
    protected bool $checkTime12Hour = false;

    /**
     * @param bool $requiresMeridiem
     * @param string $timeSeparator
     * @return static
     */
    public function checkTime12Hour(bool $requiresMeridiem = false, string $timeSeparator = ':'): static
    {
        $this->checkTime12Hour  = true;
        $this->timeSeparator    = $timeSeparator;

        $this->requiresMeridiem = $requiresMeridiem;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function validateTime12Hour($attribute, $value): bool
    {
        $meridiem = 'AM';

        if ($this->requiresMeridiem) {
            $meridiem = Str::of($value)
                ->upper()
                ->match('[AM|PM]');

            if ($meridiem->length() === 0) {
                return false;
            }
        }

        $values = Str::of($value)
            ->replace($meridiem, '')
            ->replace(' ', '')
            ->explode($this->timeSeparator);

        $expectedFormat = ($values->count() === 2) ? 'h:ia' : 'h:i:sa';

        $parsedDate = DateTime::createFromFormat(
            $expectedFormat,
            $values->join(':').$meridiem
        );

        return $parsedDate !== false &&
            Str::of($parsedDate->format($expectedFormat))
                ->matchAll('/'.$values->join('|').'/')
                ->count() === $values->count();
    }

    protected function getTime12HourFormat(): string
    {
        if ($this->requiresMeridiem) {
            return 'AM';
        }else{
            return  collect(['12', '00', '00'])->join($this->timeSeparator);
        }
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        $message = 'The :attribute does not contain a valid time. It needs be in the following format: ' .collect(['12', '00', '00'])->join($this->timeSeparator);

        if ($this->requiresMeridiem) {
            return $message.' AM';
        }

        return $message;
    }
}
