<?php

namespace Simtabi\Enekia\Laravel\Rules\Localization;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;

class LocationCoordinates extends AbstractRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * The latitude and longitude may have a maximum of
     * eight digits after the decimal point. This provides
     * an accuracy of up to ~1 millimeter.
     *
     * Requires that the given value is a comma-separated set of latitude and longitude coordinates
     *
     **/
    public function passes($attribute, $value) : bool
    {
        return preg_match(
                '/^[-]?((([0-8]?[0-9])(\.(\d{1,8}))?)|(90(\.0+)?)),\s?[-]?((((1[0-7][0-9])|([0-9]?[0-9]))(\.(\d{1,8}))?)|180(\.0+)?)$/',
                $value
            ) > 0;
    }

}