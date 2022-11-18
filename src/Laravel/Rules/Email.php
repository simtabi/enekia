<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\EmailDomain;
use Validator;

class Email extends AbstractRule implements Rule
{

    use EmailDomain;

    /**
     * Create a new rule instance.
     *
     */
    public function __construct()
    {
        $this->parameters = func_get_args();

        parent::__construct();
    }

    public function passes($attribute, $value)
    {

        $this->grabRuleData($attribute, $value);

       if ($this->checkEmailDomainOnSystem) {
           return $this->validateEmailDomainOnSystem($attribute, $value);
       }elseif ($this->checkEmailDomain) {
           return $this->validateEmailDomain($attribute, $value);
       }

       return  false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkEmailDomainOnSystem){
            return [
                'key'        => 'email.domain_on_system',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'domain'    => $this->value,
                ],
            ];
        }elseif ($this->checkEmailDomain){
            return [
                'key'        => 'email.domain',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'domains'   => implode(', ', $this->emailDomains),
                ],
            ];
        }elseif ($this->checkMultipleEmails){
            return [
                'key'        => 'email.multiple',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'errors'    => $this->errors->implode(', '),
                ],
            ];
        }elseif ($this->checkMultipleEmails){
            return [
                'key'        => 'email.multiple',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'plural'    => Str::plural('domain', count($this->emailDomains)),
                    'domains'   => implode(
                        ', ', array_map(function ($domain) {
                            return '@'.$domain;
                        },
                            $this->emailDomains
                        )
                    ),
                ],
            ];
        }

        return '';
    }

}
