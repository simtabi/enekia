<?php

namespace Simtabi\Enekia\Laravel\Rules\Localization;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Helpers\NorthAmericanStates;
use Simtabi\Enekia\Laravel\AbstractRule;
use Exception;

class IsAStateInNorthAmerica extends AbstractRule implements Rule
{
    private NorthAmericanStates $handler;
    private bool                $abbrName = false;
    private bool                $fullName = false;

    /**
     * @param string $iso2CountryCode
     */
    public function __construct(string $iso2CountryCode)
    {
        $this->handler = new NorthAmericanStates($iso2CountryCode);
    }

    /**
     * @return self
     */
    public function doAbbreviatedName(): self
    {
        $this->abbrName = true;
        return $this;
    }

    /**
     * @return self
     */
    public function doFullName(): self
    {
        $this->fullName = true;
        return $this;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws Exception
     */
    public function passes($attribute, $value)
    {

        if ($this->abbrName)
        {
            return $this->handler->isAbbreviatedName($value);
        }elseif ($this->fullName)
        {
            return $this->handler->isFullName($value);
        }else
        {
            throw new Exception('You must chose a validation type');
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        if ($this->abbrName)
        {
            return __("ekenia::messages.is_a_state_in_north_america.abbr", [
                'attribute' => $this->attribute,
            ]);
        }elseif ($this->fullName)
        {
            return __("ekenia::messages.is_a_state_in_north_america.full", [
                'attribute' => $this->attribute,
            ]);
        }
        return '';
    }

}