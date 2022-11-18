<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Barcode;

use Illuminate\Support\Str;

trait ISMN
{

    /**
     * @var bool
     */
    protected bool $checkIfIsISMN = false;

    /**
     * Validates ISMN Barcode type
     *
     * @return static
     */
    public function checkIfIsISMN(): static
    {
        $this->checkIfIsISMN = true;

        return $this;
    }

    public function validateISMN($attribute, $value): bool
    {
        $value = collect(str_split(Str::of($value)->replaceMatches('/[- _]/', '')));

        if ($value->count() !== 13) {
            return false;
        }

        $startingSequence = $value->slice(0, 4)->join('');

        if ($startingSequence !== '9790') {
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

}