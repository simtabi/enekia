<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\Domain;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Psr\SimpleCache\InvalidArgumentException;
use Simtabi\Enekia\Laravel\Validators\Disposable\AbstractDisposableHandler;

class DisposableDomain extends AbstractDisposableHandler
{
    protected function getJsonFilePath(): string
    {
        return __DIR__.'/../../../../resources/data/disposable/domains.json';
    }
}
