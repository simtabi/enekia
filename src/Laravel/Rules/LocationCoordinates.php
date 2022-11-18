<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class LocationCoordinates extends AbstractRule implements Rule
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
    }

    /**
     * Determine if the validation rule passes.
     *
     * The latitude and longitude may have a maximum of
     * eight digits after the decimal point. This provides
     * an accuracy of up to ~1 millimeter.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        return preg_match(
            '/^[-]?((([0-8]?[0-9])(\.(\d{1,8}))?)|(90(\.0+)?)),\s?[-]?((((1[0-7][0-9])|([0-9]?[0-9]))(\.(\d{1,8}))?)|180(\.0+)?)$/',
            $value
        ) > 0;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return 'location_coordinates';
    }
}
