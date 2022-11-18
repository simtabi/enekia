<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class CryptoCurrencyAddress extends AbstractRule implements Rule
{
    /**
     * @var bool
     */
    private bool $checkBitcoin = false;

    /**
     * @var bool
     */
    private bool $checkEthereum = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->checkBitcoin){
            $bech32 = '/^(bc1)[a-z0-9]{25,39}$/';
            $base58 = '/^(1|3)[A-HJ-NP-Za-km-z1-9]{25,39}$/';

            if (substr($value, 0, 3) === 'bc1')
            {
                return preg_match($bech32, $value);
            }

            return preg_match($base58, $value);
        }elseif ($this->checkEthereum){
            return preg_match('/^(0x)[0-9a-f]{40}$/i', $value);
        }

        return  false;
    }


    public function checkBitcoinAddress(): static
    {
        $this->checkBitcoin = true;

        return $this;
    }

    public function checkEthereumAddress(): static
    {
        $this->checkEthereum = true;

        return $this;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkBitcoin){
            return 'crypto_currency_address.bitcoin';
        }elseif ($this->checkEthereum){
            return 'crypto_currency_address.ethereum';
        }

        return '';
    }

}