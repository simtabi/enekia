<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait Slug
{
    protected bool $checkIfIsSlug = false;

    public function checkIfIsSlug(): static
    {
        $this->checkIfIsSlug = true;

        return $this;
    }

    public function validateSlug($attribute, $value): bool
    {
        return (bool) preg_match("/^[a-z0-9]+(?:-[a-z0-9]+)*$/i", $value);
    }
    
}
