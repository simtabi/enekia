<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class TelephoneNumber extends AbstractRule implements Rule
{

    /**
     * Indicates if phone number is to be validated as a Dutch phone number
     *
     * @var bool
     */
    protected $dutchPhoneNumber = false;

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
     * The telephone number must be 7 - 15 characters in length,
     * and composed entirely of integers.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        if ($this->dutchPhoneNumber){
            return $this->isDutchPhone($value);
        }

        else{
            return preg_match('/^[0-9]{7,15}$/', $value) > 0;
        }
    }

    public function validateAsDutchPhoneNumber()
    {
        $this->dutchPhoneNumber = true;

        return $this;
    }

    public function isDutchPhone($value): bool
    {
        return preg_match('/^(\+|00|0)(31\s?)?(6[\s-]?[1-9][0-9]{7}|[1-9][0-9][\s-]?[1-9][0-9]{6}|[1-9][0-9]{2}[\s-]?[1-9][0-9]{5})$/', $value) != false;
    }


    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->dutchPhoneNumber){
            return 'telephone_number.dutch_phone';
        }

        return 'telephone_number.general';
    }
}
