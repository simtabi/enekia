<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Str;
use Simtabi\Enekia\Laravel\Validators\Disposable\AbstractDisposableHandler;

class DisposablePhoneNumber extends AbstractDisposableHandler
{

    protected function getJsonFilePath(): string
    {
        return __DIR__.'/../../../../resources/data/disposable/phone-numbers.json';
    }
}
