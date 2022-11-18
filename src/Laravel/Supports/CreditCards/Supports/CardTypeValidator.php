<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Supports;


use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class CardTypeValidator extends AbstractRule implements Rule
{
    protected static array $cardTypes = [
        // Debit cards must come first, since they have more specific patterns than their credit-card equivalents.

        'visaelectron' => [
            'type'      => 'visaelectron',
            'pattern'   => '/^4(026|17500|405|508|844|91[37])/',
            'length'    => [16],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
        'maestro' => [
            'type'      => 'maestro',
            'pattern'   => '/^(5(018|0[23]|[68])|6(39|7))/',
            'length'    => [12, 13, 14, 15, 16, 17, 18, 19],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
        'forbrugsforeningen' => [
            'type'      => 'forbrugsforeningen',
            'pattern'   => '/^600/',
            'length'    => [16],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
        'dankort' => [
            'type'      => 'dankort',
            'pattern'   => '/^5019/',
            'length'    => [16],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
        // Credit cards
        'visa' => [
            'type'      => 'visa',
            'pattern'   => '/^4/',
            'length'    => [13, 16],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
        'mastercard' => [
            'type'      => 'mastercard',
            'pattern'   => '/^(5[0-5]|2[2-7])/',
            'length'    => [16],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
        'amex' => [
            'type'      => 'amex',
            'pattern'   => '/^3[47]/',
            'format'    => '/(\d{1,4})(\d{1,6})?(\d{1,5})?/',
            'length'    => [15],
            'cvcLength' => [3, 4],
            'luhn'      => true,
        ],
        'dinersclub' => [
            'type'      => 'dinersclub',
            'pattern'   => '/^3[0689]/',
            'length'    => [14],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
        'discover' => [
            'type'      => 'discover',
            'pattern'   => '/^6([045]|22)/',
            'length'    => [16],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
        'unionpay' => [
            'type'      => 'unionpay',
            'pattern'   => '/^(62|88)/',
            'length'    => [16, 17, 18, 19],
            'cvcLength' => [3],
            'luhn'      => false,
        ],
        'jcb' => [
            'type'      => 'jcb',
            'pattern'   => '/^35/',
            'length'    => [16],
            'cvcLength' => [3],
            'luhn'      => true,
        ],
    ];

    public static function checkCreditCardType(string $number): string
    {
        foreach (self::$cardTypes as $type => $card) {
            if (preg_match($card['pattern'], $number)) {
                return $type;
            }
        }

        return false;
    }

    public static function validCreditCard($number, $type = null): array
    {

        // Strip non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);

        if (empty($type)) {
            $type = self::checkCreditCardType($number);
        }

        if (array_key_exists($type, self::$cardTypes) && self::validCard($number, $type)) {
            return [
                'valid'  => true,
                'number' => $number,
                'type'   => $type,
            ];
        }

        return [
            'valid'  => false,
            'number' => '',
            'type'   => '',
        ];
    }

    protected static function validCard(string $cardNumber, ?string $cardType): bool
    {
        if (empty($cardType)){
            return  false;
        }

        return
            self::validLength($cardNumber, $cardType)
            && (strlen($cardNumber) >= 13 && strlen($cardNumber) <= 19)
            && LuhnValidator::checksumIsValid(LuhnValidator::getChecksum($cardNumber))
            && (
                self::validPattern($cardNumber, $cardType)
                && self::validLength($cardNumber, $cardType)
                && self::validLuhn($cardNumber, $cardType)
            );
    }

    protected static function validPattern(string $cardNumber, string $cardType): bool|int
    {
        return preg_match(self::$cardTypes[$cardType]['pattern'], $cardNumber);
    }

    protected static function validLength(string $cardNumber, string $cardType): bool
    {
        foreach (self::$cardTypes[$cardType]['length'] as $length) {
            if (strlen($cardNumber) == $length) {
                return true;
            }
        }

        return false;
    }

    protected static function validLuhn(string $cardNumber, string $cardType): bool
    {
        return !self::$cardTypes[$cardType]['luhn'] || self::checkLuhn($cardNumber);
    }

    protected static function checkLuhn(string $cardNumber): bool
    {
        $checksum = 0;
        for ($i = (2 - (strlen($cardNumber) % 2)); $i <= strlen($cardNumber); $i += 2) {
            $checksum += (int)($cardNumber[$i - 1]);
        }

        // Analyze odd digits in even length strings or even digits in odd length strings.
        for ($i = (strlen($cardNumber) % 2) + 1; $i < strlen($cardNumber); $i += 2) {
            $digit = (int)($cardNumber[$i - 1]) * 2;
            $checksum = $digit < 10 ? $checksum + $digit : $checksum + ($digit - 9);
        }

        return ($checksum % 10) == 0;
    }

}