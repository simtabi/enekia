<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Locale\DE\Company;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class VatNumber implements Rule
{
    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        $string = Str::of($value)
            ->upper()
            ->replace(' ', '');

        return $string->startsWith('DE') && $string->match('/[0-9]{9}/')->isNotEmpty();
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return ':attribute does not contain a valid German VAT number';
    }
}
