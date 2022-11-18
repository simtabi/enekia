<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait Hostname
{

    /**
     * @var bool
     */
    protected bool $checkHostname = false;

    protected function checkHostname(string $hostname): static
    {
        $this->checkHostname = true;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function validateHostname($attribute, $value): bool
    {
        return preg_match('/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/', $value) != false;
    }

}
