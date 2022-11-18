<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

use Illuminate\Support\Str;

trait MacAddress
{

    /**
     * @var string
     */
    private string $separatorSign;

    /**
     * @var bool
     */
    protected bool $checkMacAddress = false;

    /**
     * @param string $separatorSign
     * @return static
     */
    public function checkMacAddress(string $separatorSign = ':'): static
    {
        $this->checkMacAddress = true;
        $this->separatorSign   = $separatorSign;

        return $this;
    }

    public function validateMacAddress($attribute, $value): bool
    {
        $values = (Str::of($value))->replace($this->separatorSign, ':');

        return (filter_var($values, FILTER_VALIDATE_MAC) !== false) || (preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $value) > 0);
    }

}
