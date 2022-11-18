<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Traits;

use Simtabi\Enekia\Laravel\Validators\CreditCards\Exceptions\CreditCardChecksumException;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Exceptions\CreditCardException;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Exceptions\CreditCardLengthException;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Factories\CreditCardFactory;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Supports\CardTypeValidator;

trait CardNumber
{

    /**
     * @var bool
     */
    protected bool    $checkCardNumber;

    /**
     * @var string|null
     */
    protected ?string $cardType;

    public function checkCardNumber(?string $cardType = null): static
    {
        $this->checkCardNumber = true;
        $this->cardType        = $cardType;

        return $this;
    }

    public function validateCardNumber($attribute, $value): bool
    {
        try {

            if (!empty($this->cardType)) {

                if (!CardTypeValidator::checkCreditCardType($value)){
                    $this->message = self::MSG_CARD_PATTER_INVALID;

                    return false;
                }
            }

            return CreditCardFactory::makeFromNumber($value)->isValidCardNumber();

        } catch (CreditCardLengthException $ex) {
            $this->message = self::MSG_CARD_LENGTH_INVALID;

            return false;
        } catch (CreditCardChecksumException $ex) {
            $this->message = self::MSG_CARD_CHECKSUM_INVALID;

            return false;
        } catch (CreditCardException $ex) {
            $this->message = self::MSG_CARD_INVALID;

            return false;
        }
    }

}
