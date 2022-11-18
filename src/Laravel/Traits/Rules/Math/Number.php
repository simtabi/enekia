<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Math;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

/**
 * The field under validation must be a float number.
 *
 * @package Simtabi\Enekia\Laravel\Rules
 */
class Number extends AbstractRule implements Rule
{

    /**
     * @var bool
     */
    private bool $checkFloat = false;

    /**
     * @var bool
     */
    private bool $checkOdd = false;

    /**
     * @var bool
     */
    private bool $checkEven = false;

    /**
     * Create a new rule instance.
     *
     */
    public function __construct()
    {
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
        if ($this->checkFloat){
            $regex = '/^(?:[-+])?(?:[0-9]+)?(?:\\.[0-9]*)?(?:[eE][\\+\\-]?(?:[0-9]+))?$/';

            if (!$value || $value === '.' || $value === '-' || $value === '+') {
                return false;
            }

            $value = str_replace(',', '.', $value);

            return is_numeric($value) && preg_match($regex, $value);
        }elseif ($this->checkOdd){
            return intval($value) % 2 !== 0;
        }elseif ($this->checkEven){
            return intval($value) % 2 === 0;
        }

        return false;
    }

    public function validateFloat(): static
    {
        $this->checkFloat = true;

        return $this;
    }

    public function validateOdd(): static
    {
        $this->checkOdd = true;

        return $this;
    }

    public function validateEven(): static
    {
        $this->checkEven = true;

        return $this;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function getMessageKey(): string|null|array
    {
        if ($this->checkFloat) {
            return 'number.float';
        }elseif ($this->checkOdd) {
            return 'number.odd';
        }elseif ($this->checkEven) {
            return 'number.even';
        }

        return '';
    }
}
