<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Facades;

use Illuminate\Support\Facades\Facade;

class DisposableDomainFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'disposable_email.domains';
    }
}