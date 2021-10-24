<?php

use Simtabi\Enekia\Support\OffensiveWordChecker;

if (!function_exists('is_offensive_word')) {
    function is_offensive_word($text):bool
    {
        return (new OffensiveWordChecker())->isOffensiveWord($text);
    }
}