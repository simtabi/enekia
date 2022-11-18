<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Barcode;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRegexRule;

trait ISSN
{

    protected function issnPattern(): string
    {
        return "/^[0-9]{4}-[0-9]{3}[0-9xX]$/";
    }

    public function validateISSN($attribute, $value)
    {
        return $this->passes($attribute, $value) && $this->checkSumMatchesIssn($value);
    }

    /**
     * Determine if checksum matches
     *
     * @param $value
     * @return bool
     */
    private function checkSumMatchesIssn($value): bool
    {
        return $this->calculateIssnChecksum($value) === $this->parseIssnChecksum($value);
    }

    /**
     * Calculate checksum from the current value
     *
     * @param $value
     * @return int
     */
    private function calculateIssnChecksum($value): int
    {
        $checksum     = 0;
        $issn_numbers = str_replace('-', '', $value);

        foreach (range(8, 2) as $num => $multiplicator) {
            $checksum += $issn_numbers[$num] * $multiplicator;
        }

        $remainder = ($checksum % 11);

        return $remainder === 0 ? 0 : 11 - $remainder;
    }

    /**
     * Parse attached checksum of current value (last digit)
     *
     * @param $value
     * @return int
     */
    private function parseIssnChecksum($value): int
    {
        $last = substr($value, -1);

        return strtolower($last) === 'x' ? 10 : intval($last);
    }
}
