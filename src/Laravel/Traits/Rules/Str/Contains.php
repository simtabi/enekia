<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

use Illuminate\Support\Str;

trait Contains
{
    /** @var array */
    private array $needle = [];

    /** @var bool */
    protected bool $mustContainAll    = false;

    protected bool $checkIfItContains = false;

    public function checkIfItContains(array|string $needles, bool $strictCheck = false): static
    {
        $this->checkIfItContains = true;
        $this->mustContainAll    = $strictCheck;
        $this->needle            = is_string($needles) ? [$needles] : $needles;

        return $this;
    }

    public function validateContains($attribute, $value): bool
    {
        if (empty($this->needle)) {
            return false;
        }

        $matched = collect($this->needle)->reject(function ($needle) use ($value) {
            return ! Str::contains($value, $needle);
        });

        if ($this->mustContainAll) {
            return Str::containsAll($value, $this->needle);
        }

        return $matched->isNotEmpty();
    }

}
