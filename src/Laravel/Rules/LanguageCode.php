<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Validators\Iso\Iso6391;

class LanguageCode extends AbstractRule implements Rule
{

    /**
     * Array of supporting parameters.
     *
     **/
    protected array $parameters;

    /**
     * Constructor.
     *
     **/
    public function __construct()
    {
        $this->parameters = func_get_args();
    }

    /**
     * Determine if the validation rule passes.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $array = ($this->parameters[0] ?? 2) === 2 ? Iso6391::$alpha2 : Iso6391::$alpha3;

        return array_key_exists(strtoupper($value), $array);
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return [
            'key'        => 'language_code',
            'parameters' => [
                'language_code' => 'alpha-' . ($this->parameters[0] ?? 2),
            ],
        ];
    }
}
