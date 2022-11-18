<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

trait MaxWords
{
    protected bool $checkIfHasMaxWords = false;
    protected int  $wordLimit;

    public function checkIfIsIfHasMaxWords(int $wordLimit): static
    {
        $this->checkIfHasMaxWords = true;
        $this->wordLimit          = $wordLimit;

        return $this;
    }

    public function validateMaxWords($attribute, $value): bool
    {
        return count(preg_split('~[^\p{L}\p{N}\']+~u', $value)) <= $this->wordLimit;
    }

}
