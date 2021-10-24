<?php

namespace Simtabi\Enekia\Rules\CreditCard;

use Simtabi\Enekia\Rules\CreditCard\Cards\AmericanExpress;
use Simtabi\Enekia\Rules\CreditCard\Cards\Dankort;
use Simtabi\Enekia\Rules\CreditCard\Cards\DinersClub;
use Simtabi\Enekia\Rules\CreditCard\Cards\Discovery;
use Simtabi\Enekia\Rules\CreditCard\Cards\Forbrugsforeningen;
use Simtabi\Enekia\Rules\CreditCard\Cards\Hipercard;
use Simtabi\Enekia\Rules\CreditCard\Cards\Jcb;
use Simtabi\Enekia\Rules\CreditCard\Cards\Maestro;
use Simtabi\Enekia\Rules\CreditCard\Cards\Mastercard;
use Simtabi\Enekia\Rules\CreditCard\Cards\Mir;
use Simtabi\Enekia\Rules\CreditCard\Cards\Troy;
use Simtabi\Enekia\Rules\CreditCard\Cards\UnionPay;
use Simtabi\Enekia\Rules\CreditCard\Cards\Visa;
use Simtabi\Enekia\Rules\CreditCard\Cards\VisaElectron;
use Simtabi\Enekia\Exceptions\CreditCardException;

class Factory
{
    protected static $available_cards = [
        // Firs debit cards
        Dankort::class,
        Forbrugsforeningen::class,
        Maestro::class,
        VisaElectron::class,
        // Debit cards
        AmericanExpress::class,
        DinersClub::class,
        Discovery::class,
        Jcb::class,
        Hipercard::class,
        Mastercard::class,
        UnionPay::class,
        Visa::class,
        Mir::class,
        Troy::class,
    ];

    /**
     * @param string|mixed $card_number
     *
     * @return \Simtabi\Enekia\Rules\CreditCard\Cards\Card
     * @throws \Simtabi\Enekia\Exceptions\CreditCardException
     */
    public static function makeFromNumber($card_number)
    {
        return self::determineCardByNumber($card_number);
    }

    /**
     * @param string|mixed $card_number
     *
     * @return mixed
     * @throws \Simtabi\Enekia\Exceptions\CreditCardException
     */
    protected static function determineCardByNumber($card_number)
    {
        foreach (self::$available_cards as $card) {
            if (preg_match($card::$pattern, $card_number)) {
                return new $card($card_number);
            }
        }

        throw new CreditCardException('Card not found.');
    }
}
