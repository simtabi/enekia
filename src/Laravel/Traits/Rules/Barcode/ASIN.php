<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Barcode;

use Illuminate\Support\Str;

trait ASIN
{

    /**
     * @var bool
     */
    protected bool $checkIfIsASIN = false;

    /**
     * Validates ASIN Barcode type
     *
     * @return static
     */
    public function checkIfIsASIN(): static
    {
        $this->checkIfIsASIN = true;

        return $this;
    }

    public function validateASIN($attribute, $value): bool
    {
        $barcode = Str::of($value)->matchAll('/[a-zA-Z0-9]/')->join('');

        if (strlen($barcode) !== 10) {
            return false;
        }

        return $value === (string) $barcode;
    }

}