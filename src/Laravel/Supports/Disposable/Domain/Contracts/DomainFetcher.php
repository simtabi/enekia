<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Contracts;

interface DomainFetcher
{
    public function handle($url): array;
}