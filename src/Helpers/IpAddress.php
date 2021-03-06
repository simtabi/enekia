<?php

namespace Simtabi\Enekia\Helpers;

use Symfony\Component\HttpFoundation\IpUtils;

class IpAddress
{
    protected $address;

    protected $v4 = [
        '10.0.0.0/8',
        '172.16.0.0/12',
        '192.168.0.0/16'
    ];

    protected $v6 = [
        'fc00::/7',
        'fd00::/8'
    ];

    public function __construct($address)
    {
        $this->address = $address;
    }

    public function isV4()
    {
        return !$this->isV6();
    }

    public function isV6()
    {
        return substr_count($this->address, ':') > 1;
    }

    public function isPrivate()
    {
        $ips = $this->isV4() ? $this->v4 : $this->v6;

        return IpUtils::checkIp($this->address, $ips);
    }

    public function isPublic()
    {
        return !$this->isPrivate();
    }

}