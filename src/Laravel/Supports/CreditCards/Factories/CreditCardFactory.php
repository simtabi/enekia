<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Factories;

use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\AmericanExpress;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Card;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Dankort;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\DinersClub;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Discovery;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Forbrugsforeningen;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Hipercard;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Jcb;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Maestro;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Mastercard;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Mir;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Troy;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\UnionPay;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Visa;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\VisaElectron;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Exceptions\CreditCardException;

class CreditCardFactory
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
     * @param  string|mixed  $card_number
     * @return Card
     *
     * @throws CreditCardException
     */
    public static function makeFromNumber($card_number)
    {
        return self::determineCardByNumber($card_number);
    }

    /**
     * @param  string|mixed  $card_number
     * @return mixed
     *
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
