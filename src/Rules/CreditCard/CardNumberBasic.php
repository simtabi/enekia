<?php

namespace Simtabi\Enekia\Rules\CreditCard;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Rules\Luhn;

class CardNumberBasic extends Luhn implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->hasValidLength($value) && parent::passes($attribute, $value);
    }

    /**
     * Check if the given value has the proper length for creditcards
     *
     * @param $value
     * @return boolean
     */
    private function hasValidLength($value): bool
    {
        return (strlen($value) >= 13 && strlen($value) <= 19);
    }



    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        return __("validation::messages.credit_card.basic", [
            'attribute' => $this->attribute,
        ]);
    }
}
