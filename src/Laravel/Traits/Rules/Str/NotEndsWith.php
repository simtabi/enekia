<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

use Illuminate\Support\Str;

trait NotEndsWith
{
    private   array $needle;
    protected bool  $checkIfNotEndsWith = false;

    public function checkIfNotEndsWith(array|string $needle): static
    {
        $this->checkIfNotEndsWith = true;
        $this->needle             = is_string($needle) ? [$needle] : $needle;

        return $this;
    }

    public function validateNotEndsWith($attribute, $value): bool
    {
        if (empty($this->needle))
        {
            return true;
        }

        return !Str::endsWith($value, $this->needle);
    }

}