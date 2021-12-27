<?php declare(strict_types=1);

namespace Simtabi\Enekia\Validators;

use Simtabi\Enekia\Validators\Traits\WithRespectValidationTrait;

class HtmlValidator
{

    use WithRespectValidationTrait;

    /**
     * Check if a string has some html tags
     * Example: '<p>My string</p>' => true
     * @param string $string
     * @param string|null $exceptions
     * @return bool
     */

    public function hasHtml(string $string, string $exceptions = null): bool
    {
        if($exceptions)
        {
            $regex = "/<(?!(?:".$exceptions.")\b)([\w]+)([^>]*>)?/";
        } else {
            $regex = "/<([\w]+)([^>]*>)?/";
        }

        return preg_match($regex,$string,$m) != 0;
    }

}