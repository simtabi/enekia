<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Traits;

use Simtabi\Enekia\Laravel\Validators\CreditCards\Supports\ExpirationDateValidator;

trait CardExpirationMonth
{

    /**
     * Year field name.
     *
     * @var string
     */
    protected string $year;

    /**
     * @var bool
     */
    protected bool   $checkCardExpirationMonth = false;

    public function checkCardExpirationMonth(string $year): static
    {
        $this->checkCardExpirationMonth = true;
        $this->year                     = $year;

        return $this;
    }

    public function validateCardExpirationMonth($attribute, $value): bool
    {
        if (!(new ExpirationDateValidator($this->year, $value))->isValid()){
            $this->messageKey = static::MSG_CARD_EXPIRATION_MONTH_INVALID;
            return false;
        }

        return true;
    }

}
