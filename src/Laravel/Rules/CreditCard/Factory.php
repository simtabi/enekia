<?php

namespace Simtabi\Enekia\Laravel\Rules\CreditCard;

use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\AmericanExpress;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Card;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Dankort;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\DinersClub;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Discovery;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Forbrugsforeningen;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Hipercard;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Jcb;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Maestro;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Mastercard;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Mir;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Troy;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\UnionPay;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\Visa;
use Simtabi\Enekia\Laravel\Rules\CreditCard\Cards\VisaElectron;
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
     * @return Card
     * @throws CreditCardException
     */
    public static function makeFromNumber($card_number)
    {
        return self::determineCardByNumber($card_number);
    }

    /**
     * @param string|mixed $card_number
     *
     * @return mixed
     * @throws CreditCardException
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
