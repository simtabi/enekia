<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class Math extends AbstractRule implements Rule
{

    /**
     * Array of supporting parameters.
     *
     **/
    protected array $parameters;

    /**
     * Constructor.
     *
     **/
    public function __construct()
    {
        $this->parameters = func_get_args();

        parent::__construct();
    }

    /**
     * Determine if the validation rule passes.
     *
     * The rule has two parameters:
     * 1. The maximum number of digits before the decimal point.
     * 2. The maximum number of digits after the decimal point.
     *
     **/
    public function passes($attribute, $value) : bool
    {

    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {


        return null;
    }
}