<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\Contracts;

interface PhoneNumberFetcher
{
    public function handle($url): array;
}