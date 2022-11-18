<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime;

use Illuminate\Support\Str;
use Illuminate\Validation\Concerns\ValidatesAttributes;

trait ExtendedRFC3339
{
    use ValidatesAttributes;

    /**
     * @var bool
     */
    protected bool $checkExtendedRFC3339 = false;

    public function checkExtendedRFC3339(): static
    {
        $this->checkExtendedRFC3339  = true;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateExtendedRFC3339($attribute, $value): bool
    {

        /**
         * !!! - !!!
         * PHP doesn't validate correctly RFC3339: https://github.com/laravel/framework/issues/35387
         * for example '2020-12-21T23:59:59+00:00' or '2020-12-21T23:59:59Z' return 'false' but it is 'true'.
         * The code below uniform the date in format: 'YYYY-MM-DDThh:mm:ss.mmm+nn:nn'
         */

        /* Set format to validate */
        $format = \DateTimeInterface::RFC3339_EXTENDED;

        /**
         * Substitue 'Z' with '+00:00'
         */
        if (Str::endsWith($value, 'Z')) {
            $value = Str::replaceLast('Z', '+00:00', $value);
        } else {
            /**
             * In the GET Method, the '+' (plus) symbol is substitute with ' ' (space); for example:
             *  'dateend=2020-12-01T12:30:25+00:00'
             * will replaced in GET with:
             *  'dateend=2020-12-01T12:30:25 00:00'
             *
             * This code below "restore" the '+' symbol in the date string.
             */
            if (Str::substr($value, -6, 1) == ' ') {
                $value = Str::replaceLast(' ', '+', $value);
            }
        }

        /**
         * Split a date by '.'
         *  Example_1: '2020-12-23T12:33:44.12+00:00' will be $explode_value[0]='2020-12-23T12:33:44' and $explode_value[1]='12+00:00'
         *  Example_2: '2020-12-23T12:33:44+00:00' will be $explode_value[0]='2020-12-23T12:33:44+00:00' and $explode_value[1]=null
         */
        $explode_value = explode('.', $value);
        if (count($explode_value) == 1) {
            $value = Str::replaceLast('+', '.000+', $explode_value[0]);
        } else {
            $explode_value2 = explode('+', $explode_value[1]); // Split '12+00:00' by '+' to get millisec
            $sec_fraction   = $explode_value2[0]; // $explode_value2[0]='12'
            $numoffset      = $explode_value2[1] ?? null; // $explode_value2[1]='00:00'
            if (strlen($sec_fraction) < 3) {
                $millisec = str_pad($sec_fraction, 3, '0', STR_PAD_RIGHT); // Add leading zero to RIGHT to obtain: '120'
            } else if (strlen($sec_fraction) == 3) {
                $millisec = $sec_fraction;
            } else {
                $sec_fraction = floatval('0.' . $sec_fraction);
                $millisec     = explode('.', strval(round($sec_fraction, 3)))[1];
                $millisec     = str_pad($millisec, 3, '0', STR_PAD_RIGHT);
            }
            $value = $explode_value[0] . '.' . $millisec . '+' . $numoffset;
        }

        return $this->validateDateFormat($attribute, $value, [$format]);
    }

}