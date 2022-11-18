<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Color;

use Illuminate\Support\Str;

trait RgbColor

{

    /**
     * @var bool
     */
    protected bool $checkRgbColor = false;

    /**
     * @return static
     */
    public function checkRgbColor(): static
    {
        $this->checkRgbColor = true;

        return $this;
    }

    public function validateRgbColor($attribute, $value): bool
    {
        $rgb = Str::of($value)
            ->replace(' ', '')
            ->lower();

        if ($rgb->length() <= 10 || $rgb->length() > 16) {
            return false;
        }

        if (! $rgb->startsWith('rgb') || $rgb->startsWith('rgba')) {
            return false;
        }

        // check for the 2 braces
        if (! $rgb->contains('(') || ! $rgb->contains(')')) {
            return false;
        }

        // split
        $colourCodes = $rgb->matchAll('/(-?[0-9]+)/');
        if ($colourCodes->count() !== 3) {
            return false;
        }

        return $colourCodes->filter(function ($item) {
            return (int) $item >= 0 && (int) $item <= 255;
        })->count() === 3;
    }

}
