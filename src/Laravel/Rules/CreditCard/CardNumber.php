<?php

namespace Simtabi\Enekia\Laravel\Rules\CreditCard;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Exceptions\CreditCardChecksumException;
use Simtabi\Enekia\Exceptions\CreditCardException;
use Simtabi\Enekia\Exceptions\CreditCardLengthException;
use Simtabi\Enekia\Laravel\AbstractRule;

class CardNumber extends AbstractRule implements Rule
{
    public const MSG_CARD_INVALID          = 'validation.credit_card.card_invalid';
    public const MSG_CARD_PATTER_INVALID   = 'validation.credit_card.card_pattern_invalid';
    public const MSG_CARD_LENGTH_INVALID   = 'validation.credit_card.card_length_invalid';
    public const MSG_CARD_CHECKSUM_INVALID = 'validation.credit_card.card_checksum_invalid';

    protected $message = '';

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
        try {
            return Factory::makeFromNumber($value)->isValidCardNumber();
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

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans($this->message);
    }
}
