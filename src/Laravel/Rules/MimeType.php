<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRegexRule;

class MimeType extends AbstractRegexRule implements Rule
{
    protected function pattern(): string
    {
        return "/^(multipart|application|audio|image|message|multipart|text|video|font|example|model)\/([-+.\w]+)$/i";
    }
}
