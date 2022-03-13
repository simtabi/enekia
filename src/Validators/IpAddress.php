<?php declare(strict_types=1);

namespace Simtabi\Enekia\Validators;

use Respect\Validation\Validator as Respect;

class IpAddress
{

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    public function isIP($value)
    {
        return $this->respect()->ip()->validate($value);
    }

    public function isLocalhost($address): bool
    {
        $address = empty($address) ? $_SERVER['REMOTE_ADDR'] : $address;

        if (in_array($address, [
            '127.0.0.1',
            '::1',
        ]) || ($_SERVER['SERVER_NAME'] == 'localhost')) {
            return true;
        }

        return false;
    }

    public function isIISServer($value): bool
    {
        if ( strpos(strtolower( (!empty($value) ? $value : $_SERVER['SERVER_SOFTWARE']) ), "microsoft-iis") !== true ) {
            return true;
        }
        return false;
    }

}