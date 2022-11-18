<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Barcode;

trait JAN
{

    /**
     * @var bool
     */
    protected bool $checkIfIsJAN = false;

    /**
     * Validates JAN Barcode type
     *
     * @return static
     */
    public function checkIfIsJAN(): static
    {
        $this->checkIfIsJAN = true;

        return $this;
    }

    public function validateJAN($attribute, $value): bool
    {
        $barcode = collect(str_split($value));

        if ($barcode->count() !== 13) {
            return false;
        }

        $countryCode = $barcode->slice(0, 2)->join('');

        if ($countryCode !== '45' && $countryCode !== '49') {
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

}