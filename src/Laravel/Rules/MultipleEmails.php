<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class MultipleEmails implements Rule
{
    protected $errors;

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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $emails       = array_map('trim', explode(',', $value));
        $validator    = Validator::make(['emails' => $emails], ['emails.*' => 'email:filter']);
        $this->errors = collect($validator->errors())->map(function ($errors, $key) use ($emails) {
            $key = str_replace('emails.', '', $key);
            return collect($errors)->map(function ($error) use ($emails, $key) {
                return $emails[$key];
            });
        })->flatten();

        return $validator->passes();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email address isn\'t valid: ' . $this->errors->implode(', ');
    }

}