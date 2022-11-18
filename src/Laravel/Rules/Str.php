<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\CamelCase;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\Contains;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\KebabCase;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\LowerCase;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\MaxWords;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\NotContains;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\NotEndsWith;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\NotStartsWith;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\Slug;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\SnakeCase;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\TitleCase;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\UpperCase;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\WithoutWhitespace;

class Str extends AbstractRule implements Rule
{

    use ASCII;
    use CamelCase;
    use Contains;
    use KebabCase;
    use LowerCase;
    use MaxWords;
    use NotContains;
    use NotEndsWith;
    use NotStartsWith;
    use Slug;
    use SnakeCase;
    use TitleCase;
    use UpperCase;
    use WithoutWhitespace;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->checkIfHasASCII){
            return $this->validateASCII($attribute, $value);
        }elseif ($this->checkCamelCase){
            return $this->validateCamelCase($attribute, $value);
        }elseif ($this->checkIfItContains){
            return $this->validateContains($attribute, $value);
        }elseif ($this->checkKebabCase){
            return $this->validateKebabCase($attribute, $value);
        }elseif ($this->checkIfIsLowerCase){
            return $this->validateLowerCase($attribute, $value);
        }elseif ($this->checkIfHasMaxWords){
            return $this->validateMaxWords($attribute, $value);
        }elseif ($this->checkIfNotContains){
            return $this->validateNotContains($attribute, $value);
        }elseif ($this->checkIfNotEndsWith){
            return $this->validateNotEndsWith($attribute, $value);
        }elseif ($this->checkIfNotStartsWith){
            return $this->validateNotStartsWith($attribute, $value);
        }elseif ($this->checkIfIsSlug){
            return $this->validateSlug($attribute, $value);
        }elseif ($this->checkIfIsSnakeCase){
            return $this->validateSnakeCase($attribute, $value);
        }elseif ($this->checkIfIsTitleCase){
            return $this->validateTitleCase($attribute, $value);
        }elseif ($this->checkIfIsUpperCase){
            return $this->validateUpperCase($attribute, $value);
        }elseif ($this->checkIfIsWithoutWhitespace){
            return $this->validateWithoutWhitespace($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array|null
     */
    public function getMessageKey(): string|null|array|null
    {
        if ($this->checkIfHasASCII){
            return [
                'key'        => 'str.ascii',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkCamelCase){
            return [
                'key'        => 'str.camelcase',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfItContains){
            return [
                'key'        => 'str.contains',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'contains'  => $this->needle,
                    'phrases'   => implode(
                        ', ', array_map(function ($phrase) {
                            return '"'.$phrase.'"';
                        },
                            $this->needle
                        )
                    ),
                ],
            ];



            $key = sprintf('ekenia::messages.%s.%s', $this->shortname(), $this->mustContainAll ? 'strict' : 'loose');
// string_contains
            return __(
                $key,
                [

                ]
            );

        }elseif ($this->checkKebabCase){
            return [
                'key'        => 'str.kebabcase',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsLowerCase){
            return [
                'key'        => 'str.lowercase',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfHasMaxWords){
            return [
                'key'        => 'str.max_words',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'limit'     => $this->wordLimit,
                ],
            ];
        }elseif ($this->checkIfNotContains){
            return [
                'key'        => 'str.not_contains',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'needle'    => $this->needle,
                ],
            ];
        }elseif ($this->checkIfNotEndsWith){
            return [
                'key'        => 'str.not_ends_with',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'needle'    => $this->needle,
                ],
            ];
        }elseif ($this->checkIfNotStartsWith){
            return [
                'key'        => 'str.not_starts_with',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'needle'    => $this->needle,
                ],
            ];
        }elseif ($this->checkIfIsSlug){
            return [
                'key'        => 'str.slug',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsSnakeCase){
            return [
                'key'        => 'str.snakecase',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsTitleCase){
            return [
                'key'        => 'str.titlecase',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsUpperCase){
            return [
                'key'        => 'str.uppercase',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }elseif ($this->checkIfIsWithoutWhitespace){
            return [
                'key'        => 'str.without_whitespace',
                'parameters' => [
                    'attribute' => $this->attribute,
                ],
            ];
        }

        return null;
    }

}