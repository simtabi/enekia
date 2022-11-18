<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\Rules\Barcode\ASIN;
use Simtabi\Enekia\Laravel\Traits\Rules\Barcode\EAN;
use Simtabi\Enekia\Laravel\Traits\Rules\Barcode\GTIN;
use Simtabi\Enekia\Laravel\Traits\Rules\Barcode\ISBN;
use Simtabi\Enekia\Laravel\Traits\Rules\Barcode\ISMN;
use Simtabi\Enekia\Laravel\Traits\Rules\Barcode\ISSN;
use Simtabi\Enekia\Laravel\Traits\Rules\Barcode\JAN;
use Simtabi\Enekia\Laravel\Traits\Rules\Barcode\UPC;

class Barcode extends AbstractRule implements Rule
{

    use ASIN;
    use EAN;
    use GTIN;
    use ISBN;
    use ISSN;
    use ISMN;
    use JAN;
    use UPC;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        $this->grabRuleData($attribute, $value);

        if($this->checkIfIsASIN){
            $this->validateASIN($attribute, $value);
        }elseif ($this->checkIfIsEAN5 || $this->checkIfIsEAN8 || $this->checkIfIsEAN13){
            $this->validateEAN($attribute, $value);
        }elseif ($this->checkIfIsISBN10 || $this->checkIfIsISBN13){
            $this->validateISBN($attribute, $value);
        }elseif ($this->checkIfIsISMN){
            $this->validateISMN($attribute, $value);
        }elseif ($this->checkIfIsJAN){
            $this->validateJAN($attribute, $value);
        }elseif ($this->checkIfIsUPC_A || $this->checkIfIsUPC_E){
            $this->validateUPC($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkIfIsASIN){
            return [
                'key'        => 'barcode.asin',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsEAN5){
            return [
                'key'        => 'barcode.ean5',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsEAN8){
            return [
                'key'        => 'barcode.ean8',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsEAN13){
            return [
                'key'        => 'barcode.ean13',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsISBN10){
            return [
                'key'        => 'barcode.isbn10',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsISBN13){
            return [
                'key'        => 'barcode.isbn13',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsJAN){
            return [
                'key'        => 'barcode.jan',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsUPC_A){
            return [
                'key'        => 'barcode.upc_a',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsUPC_E){
            return [
                'key'        => 'barcode.upc_e',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }

        return '';
    }

}