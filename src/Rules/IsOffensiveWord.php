<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;
use Simtabi\Enekia\Helpers\OffensiveWordChecker as OffenciveWordChecker;

class IsOffensiveWord extends AbstractRule implements Rule
{
    private OffenciveWordChecker $offensiveWordChecker;

    public function __construct(OffenciveWordChecker $offensiveChecker = null)
    {
        if (!$offensiveChecker) {
            $offensiveChecker = new OffenciveWordChecker();
        }

        $this->offensiveWordChecker = $offensiveChecker;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !$this->offensiveWordChecker->isOffensiveWord($value);
    }

}


