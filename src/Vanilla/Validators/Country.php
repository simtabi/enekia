<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Respect\Validation\Validator as Respect;
use Simtabi\Pheg\Toolbox\Localization\Countries\Countries;

class Country
{

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    public function isLanguage($value): bool
    {
        if($this->respect()->languageCode()->validate($value)){
            return true;
        }elseif($this->respect()->languageCode('alpha-3')->validate($value)){
            return true;
        }
        return false;
    }

    public function isCountry($value): bool
    {
        // if we can validate it and Respect can't either
        $code  = Countries::getCountryName($value);
        $respect = $this->respect()->countryCode()->validate($value);
        if((false === $code) && (false === $respect)){
            return false;
        }
        return true;
    }

    public function isCurrency($value): bool
    {

        // if we can validate it in both alpha2 & alpha3 and Respect can't either
        if((!Countries::getCountryCode2CurrencyCode($value)) && (!$this->respect()->currencyCode()->validate($value))){
            return false;
        }
        return true;
    }

}