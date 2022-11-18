<?php

use Simtabi\Enekia\Vanilla\Validators\OffensiveWordChecker;

if (!function_exists('isOffensiveWord')) {
    function isOffensiveWord($text):bool
    {
        return (new OffensiveWordChecker())->isOffensiveWord($text);
    }
}