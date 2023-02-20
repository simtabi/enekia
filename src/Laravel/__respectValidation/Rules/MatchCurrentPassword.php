<?php

namespace Simtabi\Laranail\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MatchCurrentPassword implements Rule
{

    private $guardName = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($guardName)
    {
        $this->guardName = $guardName;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws ValidationException
     */
    public function passes($attribute, $value)
    {
        if (empty($this->guardName)) {
            throw ValidationException::withMessages(['guard' => 'You must provide a guard context name first']);
        }
        return Hash::check($value, auth($this->guardName)->user()->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your current :attribute password is incorrect. Please check and try again!';
    }

}
