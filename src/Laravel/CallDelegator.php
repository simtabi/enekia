<?php

namespace Simtabi\Enekia;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Exceptions\NotExistingRuleException;

class CallDelegator
{
    /**
     * Name of called method
     *
     * @var string
     */
    protected $name;

    /**
     * Arguments of called method
     *
     * @var array
     */
    protected $arguments;

    /**
     * Create new instance
     *
     * @param string $name
     * @param array  $arguments
     */
    public function __construct(string $name, array $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    protected function getAction(): string
    {
        return match ($this->parse('action')) {
            'assert' => 'assert',
            default  => 'validate',
        };
    }

    public function isAssertion(): bool
    {
        return $this->getAction() === 'assert';
    }

    /**
     * Get value to validate
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->arguments[0] ?? null;
    }

    /**
     * Get validation rule from current call
     *
     * @return Rule
     */
    public function getRule(): Rule
    {
        $classname = $this->getRuleClassname();

        return new $classname(...$this->getValidationAttributes());
    }

    /**
     * Get rule option attribtues
     *
     * @return array
     */
    protected function getValidationAttributes(): array
    {
        $attributes = $this->arguments;
        array_shift($attributes);

        return $attributes;
    }

    /**
     * Get classname according to current call
     *
     * @return string
     */
    private function getRuleClassname(): string
    {
        $classname = sprintf('Simtabi\Enekia\Laravel\Traits\Rules\%s', $this->parse('rule'));

        if (! class_exists($classname)) {
            throw new NotExistingRuleException(
                "Rule does not exist (" . $classname . ")"
            );
        }

        return $classname;
    }

    /**
     * Parse information from current call
     *
     * @param string $key
     * @return string|null
     */
    protected function parse(string $key): ?string
    {
        $pattern = "/^(?P<action>is|assert)(?P<rule>.*)$/";
        $result  = (bool) preg_match($pattern, $this->name, $matches);

        if ($result === false) {
            trigger_error(
                "Error: Call to undefined method " . $this->name,
                E_USER_ERROR
            );
        }

        return array_key_exists($key, $matches) ? $matches[$key] : null;
    }
}
