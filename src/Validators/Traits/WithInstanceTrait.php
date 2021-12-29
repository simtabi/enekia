<?php

namespace Simtabi\Enekia\Validators\Traits;

trait WithInstanceTrait
{

    private function __construct(){}

    public static function invoke(): self
    {
        return new self();
    }

}