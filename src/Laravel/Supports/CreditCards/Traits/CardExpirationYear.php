<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Traits;

use Simtabi\Enekia\Laravel\Validators\CreditCards\Supports\ExpirationDateValidator;

trait CardExpirationYear
{

    /**
     * Month field name.
     *
     * @var string
     */
    protected string $month;

    /**
     * @var bool
     */
    protected bool $checkCardExpirationYear;

    public function checkCardExpirationYear(string $month): static
    {
        $this->checkCardExpirationYear = true;
        $this->month                   = $month;

        return $this;
    }

    public function validateCardExpirationYear($attribute, $value): bool
    {
        if (!(new ExpirationDateValidator($value, $this->month))->isValid()){
            $this->messageKey = static::MSG_CARD_EXPIRATION_YEAR_INVALID;
            return false;
        }

        return true;
    }

}
