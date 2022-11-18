<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Barcode;

use Illuminate\Support\Str;

trait EAN
{
    /**
     * Valid lengths
     *
     * @var array
     */
    protected array $lengths = [
        8,
        13,
    ];

    protected bool $checkIfIsEAN   = false;
    protected bool $checkIfIsEAN5  = false;
    protected bool $checkIfIsEAN8  = false;
    protected bool $checkIfIsEAN13 = false;

    /**
     * Validates EAN5 Barcode type
     *
     * @return static
     */
    public function checkIfIsEAN5(): static
    {
        $this->checkIfIsEAN5 = true;

        return $this;
    }

    /**
     * Validates EAN8 Barcode type
     *
     * @return static
     */
    public function checkIfIsEAN8(): static
    {
        $this->checkIfIsEAN8 = true;

        return $this;
    }

    /**
     * Validates EAN13 Barcode type
     *
     * @return static
     */
    public function checkIfIsEAN13(): static
    {
        $this->checkIfIsEAN13 = true;

        return $this;
    }

    public function checkEANType(int $length): static
    {
        $this->lengths = [$length];

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateEAN($attribute, $value): bool
    {
        if ($this->checkIfIsEAN5) {
            $barcode = Str::of($value);

            if ($barcode->length() !== 5) {
                return false;
            }

            return true;
        }elseif ($this->checkIfIsEAN8){
            $barcode = collect(str_split($value));

            if ($barcode->count() !== 8) {
                return false;
            }

            $checkSumChar = (int) $barcode->last();

            $total = 0;
            $barcode->slice(0, 7)->each(function ($number, $index) use (&$total) {
                $multiplier = ($index % 2 === 0) ? 3 : 1;

                $total += (int) $number * $multiplier;
            });

            $checksum = (int) (ceil($total / 10) * 10) - $total;

            return $checkSumChar === $checksum;
        }elseif ($this->checkIfIsEAN13){
            $barcode = collect(str_split($value));

            if ($barcode->count() !== 13) {
                return false;
            }

            $checkSumChar = (int) $barcode->last();

            $total = 0;
            $barcode->slice(0, 12)->each(function ($number, $index) use (&$total) {
                $multiplier = ($index % 2 === 0) ? 1 : 3;

                $total += (int) $number * $multiplier;
            });

            $checksum = (int) (ceil($total / 10) * 10) - $total;

            return $checkSumChar === $checksum;
        }

        return is_numeric($value) && $this->hasAllowedEanLength($value) && $this->checksumMatchesEan($value);
    }

    /**
     * Determine if the current value has the lengths of EAN-8 or EAN-13
     *
     * @param $value
     * @return boolean
     */
    public function hasAllowedEanLength($value): bool
    {
        return in_array(strlen($value), $this->lengths);
    }

    /**
     * Try to calculate the EAN checksum of the
     * current value and check the matching.
     *
     * @param $value
     * @return bool
     */
    protected function checksumMatchesEan($value): bool
    {
        return $this->calculateEanChecksum($value) === $this->cutEanChecksum($value);
    }

    /**
     * Cut out the checksum of the current value and return
     *
     * @param $value
     * @return int
     */
    protected function cutEanChecksum($value): int
    {
        return intval(substr($value, -1));
    }

    /**
     * Calculate modulo checksum of given value
     *
     * @param  mixed $value
     * @return int
     */
    protected function calculateEanChecksum($value): int
    {
        $checksum = 0;

        // chars without check digit in reverse
        $chars = array_reverse(str_split(substr($value, 0, -1)));

        foreach ($chars as $key => $char) {
            $multiplier = $key % 2 ? 1 : 3;
            $checksum += intval($char) * $multiplier;
        }

        $remainder = $checksum % 10;

        if ($remainder === 0) {
            return 0;
        }

        return 10 - $remainder;
    }
}
