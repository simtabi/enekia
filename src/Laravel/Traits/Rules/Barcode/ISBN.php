<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Barcode;

use Illuminate\Support\Str;

trait ISBN
{
    /**
     * Valid lengths
     *
     * @var array
     */
    protected array $lengths = [
        10,
        13,
    ];

    /**
     * @var bool
     */
    protected bool $checkIfIsISBN10 = false;

    /**
     * @var bool
     */
    protected bool $checkIfIsISBN13 = false;



    /**
     * Validates ISBN10 Barcode type
     *
     * @return static
     */
    public function checkIfIsISBN10(): static
    {
        $this->checkIfIsISBN10 = true;

        return $this;
    }

    /**
     * Validates ISBN13 Barcode type
     *
     * @return static
     */
    public function checkIfIsISBN13(): static
    {
        $this->checkIfIsISBN10 = true;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateISBN($attribute, $value)
    {

        if ($this->checkIfIsISBN10){
            $values = collect(str_split(Str::of($value)->replaceMatches('/[- _]/', '')));

            if ($values->count() !== 10) {
                return false;
            }

            $total = 0;
            $values->each(static function ($item, $index) use (&$total) {
                $multiplier = 10 - $index;

                $total += (int) $item * $multiplier;
            });

            return ($total % 11) === 0;
        }elseif ($this->checkIfIsISBN13){
            $value = collect(str_split(Str::of($value)->replaceMatches('/[- _]/', '')));

            if ($value->count() !== 13) {
                return false;
            }

            $total = 0;
            $value->each(static function ($item, $index) use (&$total) {
                // We use a multiplier of 1 for an odd index and 3 for an even index
                $multiplier = ($index % 2 === 0) ? 1 : 3;

                $total += (int) $item * $multiplier;
            });

            return ($total % 10) === 0;
        }


        // normalize value
        $value = preg_replace("/[^0-9x]/i", '', $value);

        if (!$this->hasAllowedEanLength($value)) {
            return false;
        }

        return match (strlen($value)) {
            10      => $this->shortChecksumMatches($value),
            13      => $this->checksumMatchesEan($value),
            default => false,
        };
    }

    /**
     * Determine if checksum for ISBN-10 numbers is valid
     *
     * @param $value
     * @return bool
     */
    private function shortChecksumMatches($value): bool
    {
        return $this->getShortChecksum($value) % 11 === 0;
    }

    /**
     * Calculate checksum of short ISBN numbers
     *
     * @param $value
     * @return float|int
     */
    private function getShortChecksum($value): float|int
    {
        $checksum   = 0;
        $multiplier = 10;
        foreach (str_split($value) as $digit) {
            $digit     = strtolower($digit) == 'x' ? 10 : intval($digit);
            $checksum += $digit * $multiplier;
            $multiplier--;
        }

        return $checksum;
    }
}
