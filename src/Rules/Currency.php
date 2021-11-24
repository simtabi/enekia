<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use League\ISO3166\ISO3166;
use Simtabi\Enekia\AbstractRule;
use Exception;

class Currency extends AbstractRule implements Rule
{

    private bool $numericCode = false;
    private bool $alphaSymbol = false;
    private bool $alphaCode   = false;

    public function doNumericCode()
    {
        $this->numericCode = true;
    }

    public function doAlphaSymbol()
    {
        $this->alphaSymbol = true;
    }

    public function doAlphaCode()
    {
        $this->alphaCode = true;
    }


    /**
     * Determine if the validation rule passes.
     *
     * The monetary figure requires three parameters:
     * 1. The currency symbol required e.g. '$', '£', '€'.
     * 2. The maximum number of digits before the decimal point.
     * 3. The maximum number of digits after the decimal point.
     *
     * @param string $attribute .
     * @param mixed $value .
     * @return bool.
     *
     *
     * @throws Exception
     */
    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        if ($value === null || $value === '') {
            return false;
        }

        if ($this->numericCode){
            // @todo
            $this->messageKey = 'numeric';
        }elseif ($this->alphaSymbol){
            $this->messageKey = 'symbol';
            return preg_match(
                "/^\\{$this->parameters[0]}[0-9]{1,{$this->parameters[1]}}(\.[0-9]{1,{$this->parameters[2]}})?$/", $value
            );
        }elseif ($this->alphaCode) {
            $this->messageKey = 'code';
            return in_array($value, array_unique(data_get((new ISO3166())->all(), '*.currency.*')), true);
       }

        throw new Exception("You must specify the filter method to be used i.e doNumericCode(), doAlphaSymbol(), doAlphaCode()");
    }

    public function customMessage(): string
    {

        $key = $this->messageKey;
        if (!empty($key)) {
            return __("ekenia::messages.currency.$key", [
                'attribute' => $this->attribute,
                'example'   => $this->exampleCurrencyWithSymbol(),
            ]);
        }
        return '';
    }

    /**
     * Generate an example value that satisifies the validation rule.
     *
     * @param none.
     * @return string.
     *
     **/
    public function exampleCurrencyWithSymbol()
    {
        return $this->parameters[0] .
            mt_rand(1, (int) str_repeat('9', $this->parameters[1])) . '.' .
            mt_rand(1, (int) str_repeat('9', $this->parameters[2]));
    }

}