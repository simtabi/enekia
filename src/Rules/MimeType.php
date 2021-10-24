<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRegexRule;

class MimeType extends AbstractRegexRule implements Rule
{
    protected function pattern(): string
    {
        return "/^(multipart|application|audio|image|message|multipart|text|video|font|example|model)\/([-+.\w]+)$/i";
    }
}
