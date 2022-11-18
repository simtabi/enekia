<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Barcode;

trait GTIN
{
    /**
     * Valid lengths
     *
     * @var array
     */
    protected $lengths = [
        8,
        12,
        13,
        14,
    ];

    /**
     * Determine if the validation rule passes.
     *
     * Value must be either GTIN-13 or GTIN-8, which is checked as EAN
     * by parent class. Or value must be GTIN-14 or GTIN-12 which will
     * be handled like this:
     *
     * - GTIN-14 will be checked as EAN-13 after cropping first char
     * - GTIN-12 will be checked as EAN-13 after adding leading zero
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_numeric($value)) {
            return false;
        }

        if (!$this->hasAllowedEanLength($value)) {
            return false;
        }

        return match (strlen($value)) {
            8, 13   => $this->passes($attribute, $value),
            14      => $this->checksumMatchesEan(substr($value, 1)),
            12      => $this->checksumMatchesEan('0' . $value),
            default => false,
        };

    }
}
