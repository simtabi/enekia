<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\Validation;

use Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\Facades\DisposablePhoneNumberFacade;

class Indisposable
{
    /**
     * Default error message.
     *
     * @var string
     */
    public static $errorMessage = 'Disposable phone numbers are not allowed.';

    /**
     * Validates whether an phone address does not originate from a disposable phone service.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        return DisposablePhoneNumberFacade::isNotDisposable($value);
    }
}
