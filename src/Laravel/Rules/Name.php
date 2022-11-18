<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

/**
 * The field under validation must be a valid name.
 *
 *  - no emoji
 *  - no number (if $allowNumber flag is false)
 *  - special characters are allowed
 *
 * @package Simtabi\Enekia\Laravel\Rules
 */
class Name extends AbstractRule implements Rule
{

    /**
     * @var bool
     */
    private bool $allowNumber = false;

    /**
     * Create a new rule instance.
     *
     * @param bool $allowNumber Allow number.
     * @return void
     */
    public function __construct(bool $allowNumber = false)
    {
        $this->allowNumber = $allowNumber;
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
        // check empty
        if (!trim($value)) {
            return false;
        }

        // check no emoji
        if (preg_match('/\p{S}/u', $value)) {
            return false;
        }

        if (!$this->allowNumber && !preg_match('/^([^0-9]*)$/', $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function getMessageKey(): string|null|array
    {
        return 'name';
    }
}
