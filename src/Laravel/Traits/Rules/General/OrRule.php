<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\General;

use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

trait OrRule
{
    /**
     * @var Rule[]
     */
    private $rules;

    /**
     * @var bool
     */
    protected bool $checkOrRule = false;

    /**
     * @param array $rules
     * @return static
     */
    public function checkOrRule(array $rules = []): static
    {
        $this->checkOrRule = true;
        $this->rules       = $rules;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function validateOrRule($attribute, $value): bool
    {
        foreach ($this->rules as $rule) {
            if (! Arr::has(class_implements($rule), Rule::class)) {
                $className = class_basename($rule);
                throw new Exception("$className does not implement Illuminate\Contracts\Validation\Rule interface");
            }

            $passes = $rule->passes($attribute, $value);

            if ($passes) {
                return true;
            }
        }

        return false;
    }

    public function setOrRuleMessage(): string
    {
        return collect($this->rules)->map(function ($rule) {
                return $rule->message();
        })->join(' or ');
    }
}
