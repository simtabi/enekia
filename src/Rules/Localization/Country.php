<?php

namespace Simtabi\Enekia\Rules\Localization;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use League\ISO3166\ISO3166;
use League\ISO3166\Exception\DomainException;
use League\ISO3166\Exception\OutOfBoundsException;
use InvalidArgumentException;
use Simtabi\Enekia\AbstractRule;

class Country extends AbstractRule implements Rule
{

    private   bool $iso2    = false;
    private   bool $iso3    = false;
    private   bool $name    = false;
    private   bool $numeric = false;
    protected bool $required;

    public function __construct(bool $required = true)
    {
        $this->required = $required;
    }

    public function doIso2(): self
    {
        $this->iso2 = true;
        return $this;
    }

    public function doIso3(): self
    {
        $this->iso3 = true;
        return $this;
    }

    public function doName(): self
    {
        $this->name = true;
        return $this;
    }

    public function doNumeric(): self
    {
        $this->numeric = true;
        return $this;
    }


    public function nullable(): self
    {
        $this->required = false;

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        if (! $this->required && ($value === '0' || $value === 0 || $value === null)) {
            return true;
        }

        try {

            if ($this->iso2)
            {
                return in_array($value, Arr::pluck((new ISO3166())->all(), ISO3166::KEY_ALPHA2), true);
            }elseif ($this->iso3)
            {
                return in_array($value, Arr::pluck((new ISO3166())->all(), ISO3166::KEY_ALPHA3), true);
            }
            elseif ($this->name){
                return in_array($value, Arr::pluck((new ISO3166())->all(), ISO3166::KEY_NAME), true);
            }
            elseif ($this->numeric){
                return in_array($value, Arr::pluck((new ISO3166())->all(), ISO3166::KEY_NUMERIC), true);
            }

        } catch (DomainException | InvalidArgumentException | OutOfBoundsException $exception) {
            return false;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        if ($this->iso2) {
            $key = 'iso2';
        }elseif ($this->iso3) {
            $key = 'iso3';
        }
        elseif ($this->name){
            $key = 'name';
        }
        elseif ($this->numeric){
            $key = 'numeric';
        }

        if (!empty($key)) {
            return __("validation::messages.country.$key", [
                'attribute' => $this->attribute,
            ]);
        }
        return '';
    }
}