<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Rules\Localization;

use Axiom\Support\Iso6391Alpha2;
use Axiom\Support\Iso6391Alpha3;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;
use Simtabi\Enekia\Support\ISOHelpers;
use Exception;

class Language extends AbstractRule implements Rule
{

    // language retriever
    private bool $name      = false;
    private bool $alpha2    = false;

    // ISO specific methods
    private bool $iso639_1  = false;
    private bool $iso639_2B = false;
    private bool $iso639_2T = false;

    public function byName()
    {
        $this->name = true;
    }

    public function byAlpha2()
    {
        $this->alpha2 = true;
    }

    public function byIso639_1()
    {
        $this->iso639_1 = true;
    }

    public function byIso639_2B()
    {
        $this->iso639_2B = true;
    }

    public function byIso639_2T()
    {
        $this->iso639_2T = true;
    }


    /**
     * Determine if the validation rule passes.
     *
     *
     * @throws Exception
     */
    public function passes($attribute, $value) : bool
    {
        if ($value === null || $value === '') {
            return false;
        }
        $this->setAttribute($attribute);

        // language retriever
        if ($this->name) {
            $this->messageKey = 'name';
           return !empty(ISOHelpers::ISO639()->name($value));
        }elseif ($this->alpha2){
            $this->messageKey = 'alpha2';
            return !empty(ISOHelpers::ISO639()->alpha2($value));
        }
        // ISO specific methods
        elseif ($this->iso639_1){
            $this->messageKey = 'iso639_1';
            return !empty(ISOHelpers::ISO639()->iso639_1($value));
        }elseif ($this->iso639_2B){
            $this->messageKey = 'iso639_2B';
            return !empty(ISOHelpers::ISO639()->iso639_2B($value));
        }elseif ($this->iso639_2T){
            $this->messageKey = 'iso639_2T';
            return !empty(ISOHelpers::ISO639()->iso639_2T($value));
        }

        throw new Exception("You must specify the type of IP address to validate");
    }



    /**
     * Get the validation error message.
     *
     **/
    public function customMessage() : string
    {
        $key = $this->messageKey;
        if (!empty($key)) {
            return __("ekenia::messages.language.$key", [
                'attribute' => $this->attribute,
            ]);
        }
        return '';
    }
}
