<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Barcode;

trait UPC
{

    /**
     * @var bool
     */
    protected bool $checkIfIsUPC_A = false;

    /**
     * @var bool
     */
    protected bool $checkIfIsUPC_E = false;

    /**
     * Validates UPC_A Barcode type
     *
     * @return static
     */
    public function checkIfIsUPC_A(): static
    {
        $this->checkIfIsUPC_A = true;

        return $this;
    }

    /**
     * Validates UPC_E Barcode type
     *
     * @return static
     */
    public function checkIfIsUPC_E(): static
    {
        $this->checkIfIsUPC_E = true;

        return $this;
    }

    public function validateUPC($attribute, $value): bool
    {
        if ($this->checkIfIsUPC_A){
            $barcode = collect(str_split($value));

            if ($barcode->count() !== 12) {
                return false;
            }

            $checkSumChar = (int) $barcode->last();

            $total = 0;
            $barcode->slice(0, 11)->each(function ($number, $index) use (&$total) {
                $multiplier = ($index % 2 === 0) ? 3 : 1;

                $total += (int) $number * $multiplier;
            });

            $checksum = (int) (ceil($total / 10) * 10) - $total;

            return $checkSumChar === $checksum;
        }elseif ($this->checkIfIsUPC_E){
            $barcode = collect(str_split($value));

            if ($barcode->count() !== 8) {
                return false;
            }

            if ($barcode->first() !== '1' && $barcode->first() !== '0') {
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
        }

        return false;
    }

}