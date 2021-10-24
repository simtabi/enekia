<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRegexRule;

class Bic extends AbstractRegexRule implements Rule
{
    protected function pattern(): string
    {
        return "/^[A-Za-z]{4} ?[A-Za-z]{2} ?[A-Za-z0-9]{2} ?([A-Za-z0-9]{3})?$/";
    }
}
