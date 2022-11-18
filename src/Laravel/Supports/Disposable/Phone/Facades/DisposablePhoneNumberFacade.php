<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\Facades;

use Illuminate\Support\Facades\Facade;

class DisposablePhoneNumberFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'disposable_phone.numbers';
    }
}