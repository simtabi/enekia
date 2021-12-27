<?php

namespace Simtabi\Enekia\Helpers;

use Astrotomic\ISO639\ISO639;
use EoneoPay\Currencies\ISO4217;

class ISO
{
    public static function ISO4217(): ISO4217
    {
        return new ISO4217();
    }
    public static function ISO639(): ISO639
    {
        return new ISO639();
    }
}