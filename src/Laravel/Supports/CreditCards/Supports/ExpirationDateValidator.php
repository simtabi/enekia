<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Supports;

use Carbon\Carbon;

class ExpirationDateValidator
{
    /**
     * @var string
     */
    protected string $year;

    /**
     * @var string
     */
    protected string $month;

    /**
     * ExpirationDateValidator constructor.
     *
     * @param  string  $year
     * @param  string  $month
     */
    public function __construct(string $year, string $month)
    {
        $this->setYear($year);

        $this->month = trim($month);
    }

    /**
     * @param  string  $year
     * @param  string  $month
     * @return mixed
     */
    public static function validate(string $year, string $month)
    {
        return (new static($year, $month))->isValid();
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValidYear() && $this->isValidMonth() && $this->isFeatureDate();
    }

    /**
     * @param $year
     * @return static
     */
    protected function setYear($year): static
    {
        $year = trim($year);

        if (strlen($year) == 2) {
            $year = substr(date('Y'), 0, 2).$year;
        }

        $this->year = $year;

        return $this;
    }

    /**
     * @return string
     */
    protected function month(): string
    {
        return str_pad($this->month, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return bool
     */
    protected function isValidYear(): bool
    {
        $test = '/^'.substr(date('Y'), 0, 2).'\d\d$/';

        return $this->year != '' && preg_match($test, $this->year);
    }

    /**
     * @return bool
     */
    protected function isValidMonth(): bool
    {
        return $this->month != '' && $this->month() != '00' && preg_match('/^(0[1-9]|1[0-2])$/', $this->month());
    }

    /**
     * @return bool
     */
    protected function isFeatureDate(): bool
    {
        return Carbon::now()->startOfDay()->lte(
            Carbon::createFromFormat('Y-m', $this->year.'-'.$this->month())->endOfDay()
        );
    }
}
