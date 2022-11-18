<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Respect\Validation\Validator as Respect;

class PostalCode
{

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    public function isPostalCode($value, $locale = 'US'): bool
    {
        if($this->respect()->numeric()->postalCode($locale)->validate($value)){
            return true;
        }
        return false;
    }

}