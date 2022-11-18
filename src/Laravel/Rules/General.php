<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\Rules\General\OrRule;

class General extends AbstractRule implements Rule
{
    use OrRule;

    public function __construct()
    {
        $this->parameters = func_get_args();

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $this->grabRuleData($attribute, $value);

        if ($this->checkOrRule){
            $this->setMessage($this->setOrRuleMessage());

            return $this->validateOrRule($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
          return '';
    }
}