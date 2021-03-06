<?php

declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Rules\Password;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;

class StrongPassword extends AbstractRule implements Rule
{
    /** @var int */
    protected $minCharacters = 8;

    /** @var string */
    protected $specialCharacters = '!@#$%^&*()\-_=+{};:,<."£~?|>';

    /** @var bool */
    protected $mustIncludeUppercaseCharacters = true;

    /** @var bool */
    protected $mustIncludeLowercaseCharacters = true;

    /** @var bool */
    protected $mustIncludeSpecialCharacters = false;

    /** @var bool */
    protected $mustIncludeNumbers = true;

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        $this->setAttribute($attribute);

        if (
            $this->mustIncludeUppercaseCharacters &&
            preg_match_all('/[A-Z]/', $value, $o) === 0
        ) {
            return false;
        }

        if (
            $this->mustIncludeLowercaseCharacters &&
            preg_match_all('/[a-z]/', $value, $o) === 0
        ) {
            return false;
        }

        if (
            $this->mustIncludeSpecialCharacters &&
            preg_match_all('/['.$this->specialCharacters.']/', $value, $o) === 0
        ) {
            return false;
        }

        if (
            $this->mustIncludeNumbers &&
            preg_match_all('/[0-9]/', $value, $o) === 0
        ) {
            return false;
        }

        if (mb_strlen($value, 'UTF-8') < $this->minCharacters) {
            return false;
        }

        return true;
    }

    /**
     * @param  int  $min
     * @return self
     */
    public function min(int $min): self
    {
        $this->minCharacters = $min;

        return $this;
    }

    /**
     * @param  bool  $flag
     * @return $this
     */
    public function forceUppercaseCharacters(bool $flag = true): self
    {
        $this->mustIncludeUppercaseCharacters = $flag;

        return $this;
    }

    /**
     * @param  bool  $flag
     * @return self
     */
    public function forceLowercaseCharacters(bool $flag = true): self
    {
        $this->mustIncludeLowercaseCharacters = $flag;

        return $this;
    }

    /**
     * @param  bool  $flag
     * @return self
     */
    public function forceNumbers(bool $flag = true): self
    {
        $this->mustIncludeNumbers = $flag;

        return $this;
    }

    /**
     * @param  bool  $flag
     * @return self
     */
    public function forceSpecialCharacters(bool $flag = true): self
    {
        $this->mustIncludeSpecialCharacters = $flag;

        return $this;
    }

    /**
     * @param  string  $characters
     * @return self
     */
    public function withSpecialCharacters(string $characters): self
    {
        $this->forceSpecialCharacters();
        $this->specialCharacters = $characters;

        return $this;
    }

    /**
     * @return self
     */
    public function reset(): self
    {
        $this->minCharacters                  = 8;
        $this->mustIncludeSpecialCharacters   = false;
        $this->mustIncludeNumbers             = false;
        $this->mustIncludeLowercaseCharacters = false;
        $this->mustIncludeUppercaseCharacters = false;

        return $this;
    }

    /**
     * @return string
     */
    public function customMessage(): string
    {
        $key = 'ekenia::messages.password.secure';

        $message = [];

        $message[] = __(
            $key.'.base',
            [
                'attribute' => $this->getAttribute(),
            ]
        );

        if ($this->minCharacters > 0) {
            $message[] = __(
                $key.'.min',
                [
                    'length' => $this->minCharacters,
                ]
            );
        }

        if ($this->mustIncludeUppercaseCharacters > 0) {
            $message[] = __($key.'.uppercase');
        }

        if ($this->mustIncludeLowercaseCharacters > 0) {
            $message[] = __($key.'.lowercase');
        }

        if ($this->mustIncludeNumbers > 0) {
            $message[] = __($key.'.numbers');
        }

        if ($this->mustIncludeSpecialCharacters > 0) {
            $message[] = __(
                $key.'.special',
                [
                    'characters' => $this->specialCharacters,
                ]
            );
        }

        return implode(', ', $message);
    }
}
