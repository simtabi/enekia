<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Respect\Validation\Validator as Respect;
use Symfony\Component\HttpFoundation\IpUtils;

class IpAddress
{    protected string $address;

    protected array  $v4 = [
        '10.0.0.0/8',
        '172.16.0.0/12',
        '192.168.0.0/16'
    ];

    protected array  $v6 = [
        'fc00::/7',
        'fd00::/8'
    ];

    public function __construct(string $address)
    {
        $this->address = $address;
    }

    public function respect(): Respect
    {
        return new Respect();
    }

    public function isValidIP($value): bool
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

    public function isV4(): bool
    {
        return !$this->isV6();
    }

    public function isV6(): bool
    {
        return substr_count($this->address, ':') > 1;
    }

    public function isPrivate(): bool
    {
        $ips = $this->isV4() ? $this->v4 : $this->v6;

        return IpUtils::checkIp($this->address, $ips);
    }

    public function isPublic(): bool
    {
        return !$this->isPrivate();
    }

}