<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Validators\Iso\Iso3166;
use League\ISO3166\ISO3166 as LeagueISO3166;
use Illuminate\Support\Arr;

class Country extends AbstractRule implements Rule
{

    /**
     * @var bool
     */
    protected bool $checkCountryCode = false;

    /**
     * Determine if the validation rule passes.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $this->attribute = $attribute;
        $this->value     = $value;

        if ($this->checkCountryCode){
            if (! $this->required && ($value === '0' || $value === 0 || $value === null)) {
                return true;
            }

            if (array_key_exists(strtoupper($value), Iso3166::$alpha2)){
                return true;
            }elseif (array_key_exists(strtoupper($value), Iso3166::$alpha3)){
                return true;
            }elseif(in_array($value, Arr::pluck((new LeagueISO3166())->all(), LeagueISO3166::KEY_ALPHA2), true)){
                return true;
            }elseif(in_array($value, Arr::pluck((new LeagueISO3166())->all(), LeagueISO3166::KEY_ALPHA3), true)){
                return true;
            }

            return false;
        }

        return false;
    }

    public function validateCountryCode(): static
    {
        $this->checkCountryCode = true;

        return $this;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkCountryCode){
            return [
                'key'        => 'country.code',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'code'      => $this->value,
                ],
            ];
        }

        return '';
    }
}
