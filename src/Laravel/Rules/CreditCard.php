<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Traits\CardCvc;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Traits\CardExpirationDate;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Traits\CardExpirationMonth;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Traits\CardExpirationYear;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Traits\CardNumber;

class CreditCard extends AbstractRule implements Rule
{

    use CardCvc;
    use CardExpirationDate;
    use CardExpirationMonth;
    use CardExpirationYear;
    use CardNumber;

    const MSG_CARD_CVC_INVALID                    = 'enekia.payment.credit_card.cvc_invalid';
    const MSG_CARD_EXPIRATION_MONTH_INVALID       = 'enekia.payment.credit_card.expiration_month_invalid';
    const MSG_CARD_EXPIRATION_YEAR_INVALID        = 'enekia.payment.credit_card.expiration_year_invalid';
    const MSG_CARD_EXPIRATION_DATE_INVALID        = 'enekia.payment.credit_card.expiration_date_invalid';
    const MSG_CARD_EXPIRATION_DATE_FORMAT_INVALID = 'enekia.payment.credit_card.expiration_date_format_invalid';

    const MSG_CARD_INVALID                        = 'enekia.payment.credit_card.invalid_card';
    const MSG_CARD_PATTER_INVALID                 = 'enekia.payment.credit_card.invalid_pattern';
    const MSG_CARD_LENGTH_INVALID                 = 'enekia.payment.credit_card.invalid_length';
    const MSG_CARD_CHECKSUM_INVALID               = 'enekia.payment.credit_card.invalid_checksum';

    /**
     * @var ?string
     */
    protected ?string $messageKey = null;

    public function __construct()
    {
        $this->parameters = func_get_args();

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $this->grabRuleData($attribute, $value);

        if ($this->checkCardNumber){
            return $this->validateCardNumber($attribute, $value);
        }elseif ($this->checkCardExpirationMonth){
            return $this->validateCardExpirationMonth($attribute, $value);
        }elseif ($this->checkCardExpirationYear){
            return $this->validateCardExpirationYear($attribute, $value);
        }elseif ($this->checkCardCVC){
            return $this->validateCardCvc($attribute, $value);
        }elseif ($this->checkCardExpirationDate){
            return $this->validateCardExpirationDate($attribute, $value);
        }else{
            return $this->validateCardNumber($attribute, $value)
                && $this->validateCardExpirationMonth($attribute, $value)
                && $this->validateCardExpirationYear($attribute, $value)
                && $this->validateCardCvc($attribute, $value)
                && $this->validateCardExpirationDate($attribute, $value);
        }
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkCardCVC){
            return [
                'key'        => $this->messageKey,
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkCardExpirationDate){
            return [
                'key'        => $this->messageKey,
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkCardExpirationMonth){
            return [
                'key'        => $this->messageKey,
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkCardExpirationYear){
            return [
                'key'        => $this->messageKey,
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkCardNumber){
            return [
                'key'        => $this->messageKey,
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }

        return [
            'key'        => self::MSG_CARD_INVALID,
            'parameters' => [
                'attribute' => $this->attribute,
                'value'     => $this->value,
            ],
        ];
    }
}