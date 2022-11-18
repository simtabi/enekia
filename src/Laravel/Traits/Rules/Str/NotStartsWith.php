<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

use Illuminate\Support\Str;

trait NotStartsWith
{
    private   array $needle;
    protected bool  $checkIfNotStartsWith = false;

    public function checkIfNotStartsWith(array|string $needle): static
    {
        $this->checkIfNotStartsWith = true;
        $this->needle               = is_string($needle) ? [$needle] : $needle;

        return $this;
    }

    public function validateNotStartsWith($attribute, $value): bool
    {
        if (trim($this->needle) === '')
        {
            return true;
        }

        return !Str::startsWith($value, $this->needle);
    }

}
