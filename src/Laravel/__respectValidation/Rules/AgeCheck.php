<?php

namespace Simtabi\Laranail\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class AgeCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 18;

            // using Carbon:
            return Carbon::now()->diff(new Carbon($value))->y >= $minAge;

            // return (new DateTime)->diff(new DateTime($value))->y >= $minAge;
        } catch (\Exception $e) {
            return  false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
