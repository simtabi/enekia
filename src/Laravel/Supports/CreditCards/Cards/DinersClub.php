<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Cards;

use Simtabi\Enekia\Laravel\Validators\CreditCards\Contracts\CreditCard;

class DinersClub extends Card implements CreditCard
{
    /**
     * Regular expression for card number recognition.
     *
     * @var string
     */
    public static $pattern = '/^3(0[0-5]|[68][0-9])[0-9]/';

    /**
     * Credit card type.
     *
     * @var string
     */
    protected $type = 'credit';

    /**
     * Credit card name.
     *
     * @var string
     */
    protected $name = 'dinersclub';

    /**
     * Brand name.
     *
     * @var string
     */
    protected $brand = 'Diners Club International';

    /**
     * Card number length's.
     *
     * @var array
     */
    protected $number_length = [14];

    /**
     * CVC code length's.
     *
     * @var array
     */
    protected $cvc_length = [3];

    /**
     * Test cvc code checksum against Luhn algorithm.
     *
     * @var bool
     */
    protected $checksum_test = true;
}
