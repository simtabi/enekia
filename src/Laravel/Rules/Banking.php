<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\Rules\Banking\BicNumber;
use Simtabi\Enekia\Laravel\Traits\Rules\Banking\Currency;
use Simtabi\Enekia\Laravel\Traits\Rules\Banking\IbanNumber;
use Simtabi\Enekia\Laravel\Traits\Rules\Banking\IsinNumber;
use Simtabi\Enekia\Laravel\Traits\Rules\Banking\MonetaryFigure;
use Simtabi\Enekia\Laravel\Traits\Rules\Banking\Price;
use Simtabi\Enekia\Laravel\Traits\Rules\Banking\VatNumber;

class Banking extends AbstractRule implements Rule
{

    use MonetaryFigure;
    use Currency;
    use Price;
    use VatNumber;
    use BicNumber;
    use IbanNumber;
    use IsinNumber;

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

        if ($this->checkBicNumber){
            return $this->validateBicNumber($attribute, $value);
        }elseif ($this->checkIBANNumber){
            return $this->validateIBANNumber($attribute, $value);
        }elseif ($this->checkIsinNumber){
            return $this->validateIsinNumber($attribute, $value);
        }elseif ($this->checkMonetaryFigure){
            return $this->validateMonetaryFigure($attribute, $value);
        }elseif ($this->checkPrice){
            return $this->validatePrice($attribute, $value);
        }elseif ($this->checkVatNumber){
            return $this->validateVatNumber($attribute, $value);
        }elseif ($this->checkCurrencyCode){
            return $this->validateCurrencyCode($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkBicNumber){
            return [
                'key'        => 'banking.bic_number',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkIBANNumber){
            return [
                'key'        => 'banking.iban_number',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkIsinNumber){
            return [
                'key'        => 'banking.isin_number',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkMonetaryFigure){
            return [
                'key'        => 'banking.monetary_figure',
                'parameters' => [
                    'monetary_figure' => $this->example(),
                ],
            ];
        }elseif ($this->checkPrice){
            if (is_null($this->decimalSign)) {
                return 'banking.price.general';
            }

            return [
                'key'        => 'banking.price.custom_decimal',
                'parameters' => [
                    'custom_decimal' => $this->decimalSign,
                ],
            ];
        }elseif ($this->checkVatNumber){
           return 'banking.vat_number';
        }elseif ($this->checkCurrencyCode){
            return [
                'key'        => 'banking.currency.code',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }

        return '';
    }
}