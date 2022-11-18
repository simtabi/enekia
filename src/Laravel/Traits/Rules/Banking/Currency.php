<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Banking;

use Money\Currency as BC;
use Money\Currencies;
use Illuminate\Support\Facades\App;
use League\ISO3166\ISO3166;

trait Currency
{

    /**
     * @var bool
     */
    protected bool $checkCurrencyCode = false;

    public function checkCurrencyCode(): static
    {
        $this->checkCurrencyCode = true;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateCurrencyCode($attribute, $value): bool
    {

        if ($this->checkCurrencyCode) {
            $checkCurrency   = function () use ($value) {
                if ($value === null || $value === '') {
                    return false;
                }

                $currencies = array_unique(data_get((new ISO3166())->all(), '*.currency.*'));

                return in_array($value, $currencies, true);
            };

            if (!$checkCurrency){
                return (App::make(Currencies::class))->contains(new BC($value));
            }
        }


        return false;
    }

}
