<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

use Illuminate\Support\Str;

trait NotContains
{
    private   array $needle;
    protected bool  $checkIfNotContains = false;

    public function checkIfNotContains(array|string $needle): static
    {
        $this->checkIfNotContains = true;
        $this->needle             = is_string($needle) ? [$needle] : $needle;

        return $this;
    }

    public function validateNotContains($attribute, $value): bool
    {
        if (empty($this->needle)) {
            return true;
        }

        return ! Str::contains($value, $this->needle);
    }

}
