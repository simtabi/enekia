<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Supports;

class LuhnValidator
{
    /**
     * Determine if the given checksum is valid
     *
     * @param  mixed $checksum
     * @return bool
     */
    public static function checksumIsValid($checksum): bool
    {
        return $checksum % 10 === 0;
    }

    /**
     * Calculate checksum for the given value
     *
     * @param  mixed $value
     * @return int
     */
    public static function getChecksum($value): int
    {
        $checksum = 0;
        $reverse  = strrev($value);

        foreach (str_split($reverse) as $num => $digit) {
            if (is_numeric($digit)) {
                $checksum += $num & 1 ? ($digit > 4 ? (int) $digit * 2 - 9 : (int) $digit * 2) : $digit;
            } else {
                return -1;
            }
        }

        return $checksum;
    }
}