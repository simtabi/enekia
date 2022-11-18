<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Traits;

use Simtabi\Enekia\Laravel\Validators\CreditCards\Factories\CreditCardFactory;

trait CardCvc
{

    /**
     * Credit card number.
     *
     * @var string
     */
    protected string $cardNumber;

    /**
     * @var bool
     */
    protected bool $checkCardCVC = false;

    public function checkCardCVC(string $cardNumber): static
    {
        $this->checkCardCVC = true;
        $this->cardNumber   = $cardNumber;
        return $this;
    }

    public function validateCardCvc($attribute, $value): bool
    {
        try {

            if(!CreditCardFactory::makeFromNumber($this->cardNumber)->isValidCvc($value)){
                $this->messageKey = static::MSG_CARD_CVC_INVALID;
                return false;
            }

            return true;

        } catch (\Exception $ex) {
            return false;
        }
    }

}
