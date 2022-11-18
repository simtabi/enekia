<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

use Illuminate\Support\Str;

trait IPv4
{

    /**
     * @var bool
     */
    protected bool $checkIPv4 = false;

    /**
     * @var bool
     */
    private bool $allowPrivateIpAddress = false;

    /**
     * @var string[]
     */
    private array $privateIPRanges = [
        '10.0.0.0'    => '10.255.255.255',
        '172.16.0.0'  => '172.16.255.255',
        '192.168.0.0' => '192.168.255.255',
    ];

    /**
     * @param bool $allowPrivateIpAddress
     * @return static
     */
    public function checkIPv4(bool $allowPrivateIpAddress = false): static
    {
        $this->checkIPv4             = true;
        $this->allowPrivateIpAddress = $allowPrivateIpAddress;

        return $this;
    }

    public function validateIPv4($attribute, $value): bool
    {
        $octets = Str::of($value)->explode('.');

        if ($octets->count() !== 4) {
            return false;
        }

        foreach ($octets as $octet) {
            $octet = (int) $octet;

            if ($octet < 0 || $octet > 255) {
                return false;
            }
        }

        if ($this->isInPrivateIpAddressRange($value) && ! $this->allowPrivateIpAddress) {
            return false;
        }

        return true;
    }

    private function isInPrivateIpAddressRange(string $ipAddress): bool
    {
        $ipAddressLong = ip2long($ipAddress);

        foreach ($this->privateIPRanges as $startAddress => $endAddress) {
            $startAddressLong = ip2long($startAddress);
            $endAddressLong   = ip2long($endAddress);

            if ($ipAddressLong >= $startAddressLong && $ipAddressLong <= $endAddressLong) {
                return true;
            }
        }

        return false;
    }

}
