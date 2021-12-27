<?php

namespace Simtabi\Enekia\Laravel\Rules\CreditCard;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;

class CardExpirationYear extends AbstractRule implements Rule
{
    public const MSG_CARD_EXPIRATION_YEAR_INVALID = 'validation.credit_card.card_expiration_year_invalid';

    /**
     * Month field name.
     *
     * @var string
     */
    protected $month;

    /**
     * CardExpirationYear constructor.
     *
     * @param string $month
     */
    public function __construct($month)
    {
        $this->month = $month;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new ExpirationDateValidator($value, $this->month))
            ->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans(static::MSG_CARD_EXPIRATION_YEAR_INVALID);
    }
}
