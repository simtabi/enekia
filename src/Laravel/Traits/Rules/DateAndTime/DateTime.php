<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime;

use Carbon\Exceptions\InvalidFormatException;
use DateTimeInterface;
use Illuminate\Support\Carbon;

trait DateTime
{

    protected array  $allowedMinutes;
    protected string $dateFormat;
    protected bool   $checkIfHasSpecificMinutes = false;
    protected DateTimeInterface $date;

    /**
     * @var bool
     */
    protected bool $checkAfterOrEqual = false;

    /**
     * @var bool
     */
    protected bool $checkBeforeOrEqual = false;

    /**
     * @var bool
     */
    protected bool $checkDateTime = false;

    public function checkDateTime(DateTimeInterface $date): static
    {
        $this->checkDateTime = true;
        $this->date          = $date;

        return $this;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function validateDateTime($attribute, $value): bool
    {

        if ($this->checkAfterOrEqual){
            $limitTimestamp = $this
                ->date
                ->getTimestamp();

            return strtotime($value) >= $limitTimestamp;
        }elseif ($this->checkBeforeOrEqual){
            $limitTimestamp = $this
                ->date
                ->getTimestamp();

            $providedTimestamp = strtotime($value);
            if (!$providedTimestamp) {
                return false;
            }

            return strtotime($value) <= $limitTimestamp;
        }elseif ($this->checkIfHasSpecificMinutes){
            try {
                $date = Carbon::createFromFormat($this->dateFormat, $value);
            } catch (InvalidFormatException $exception) {
                return false;
            }

            return in_array($date->minute, $this->allowedMinutes);
        }

        return false;
    }

    public function checkAfterOrEqual(): static
    {
        $this->checkAfterOrEqual = true;

        return $this;
    }

    public function checkBeforeOrEqual(): static
    {
        $this->checkBeforeOrEqual = true;

        return $this;
    }

    public function checkIfHasSpecificMinutes(array $allowedMinutes, string $dateFormat = 'Y-m-d H:i'): static
    {
        $this->checkIfHasSpecificMinutes = true;
        $this->allowedMinutes            = $allowedMinutes;
        $this->dateFormat                = $dateFormat;

        return $this;
    }

}
