<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Math;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

/**
 * The field under validation must be divisible by the given number.
 *
 * @package Simtabi\Enekia\Laravel\Rules
 */
class DivisibleBy implements Rule
{

    /**
     * @var int
     */
    private $number;

    /**
     * @var string
     */
    private $attribute;

    /**
     * Create a new rule instance.
     *
     * @param int $number Divisible by number.
     */
    public function __construct(int $number)
    {
        $this->number = $number;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;

        $floatValidation = Validator::make(
            ['float' => $value],
            ['float' => ['required', new Number()]],
        );

        return !$floatValidation->fails() && (fmod(floatval($value), intval($this->number, 10)) === 0.0);
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return [
            'key'        => 'divisible_by',
            'parameters' => [
                'attribute' => $this->attribute,
                'number'    => $this->number
            ],
        ];
    }

}
