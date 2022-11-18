<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait IPv6
{

    /**
     * @var bool
     */
    protected bool $checkIPv6 = false;

    /**
     * @return static
     */
    public function checkIPv6(): static
    {
        $this->checkIPv6 = true;

        return $this;
    }

    public function validateIPv6($attribute, $value): bool
    {
        // Based on this Stackoverflow answer: https://stackoverflow.com/a/5567938
        return preg_match('/^([0-9A-Fa-f]{0,4}:){2,7}([0-9A-Fa-f]{1,4}$|'.
            "((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.|$)){4})$/",
            $value
        ) > 0;
    }

}
