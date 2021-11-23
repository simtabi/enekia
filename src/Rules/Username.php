<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;
use Exception;

class Username extends AbstractRule implements Rule
{

    public const MIN_LENGTH = 3;
    public const MAX_LENGTH = 36;

    protected int $minLength;
    protected int $maxLength;

    /**
     * The collection of allowed usernames
     */
    protected Collection $whitelisted;

    /**
     * The collection of disallowed usernames
     */
    protected Collection $blacklisted;

    public function __construct()
    {
        $this->whitelisted = collect(config('enekekia.username.allowed'));
        $this->blacklisted = collect(config('enekekia.username.base'))->merge(config('enekekia.username.disallowed'));
    }

    /**
     * @param int|mixed $minLength
     * @return self
     */
    public function setMinLength(int $minLength = self::MIN_LENGTH): self
    {
        $this->minLength = $minLength >= self::MIN_LENGTH ? $minLength : self::MIN_LENGTH;
        return $this;
    }

    /**
     * @param int|mixed $maxLength
     * @return self
     */
    public function setMaxLength(int $maxLength = self::MAX_LENGTH): self
    {
        $this->maxLength = ($maxLength >= self::MAX_LENGTH) && ($maxLength <= self::MAX_LENGTH) ? $maxLength : self::MAX_LENGTH;
        return $this;
    }
    
    

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $this->setAttribute($attribute)->setValue(trim(strtolower($value)));

        if ($this->isTooLong()) {
            $this->messageKey = 'too_long';
            return false;
        }elseif ($this->isTooShort()) {
            $this->messageKey = 'too_short';
            return false;
        } elseif (!$this->hasValidLength() || !$this->isFormattedCorrectly($this->value)) {
            $this->messageKey = 'invalid';
            return false;
        } elseif ($this->blacklisted->contains($this->value)) {
            $this->messageKey = 'blacklisted';
            return false;
        }

        if ($this->whitelisted->contains($this->value)) {
            return true;
        }

        return false;
    }

    /**
     * Pattern for "valid" username
     *  - only alpha-numeric (a-z, A-Z, 0-9), underscore and minus
     *  - starts with an letter (alpha)
     *  - underscores and minus are not allowed at the beginning or end
     *  - multiple underscores and minus are not allowed (-- or _____)
     *  - minimum of 3 character and maximum of 36 characters
     *
     * @var string
     * @return bool
     */
    private function isFormattedCorrectly($value): bool
    {
        return preg_match('/^[a-z][a-z0-9]*(?:[_\-][a-z0-9]+)*$/i', $value) === 1;
    }

    /**
     * Check if the given value has the proper length
     *
     * @return bool
     */
    private function hasValidLength(): bool
    {
        return (strlen($this->value) >= $this->minLength && strlen($this->value) <= $this->maxLength);
    }

    private function isTooLong(): bool
    {
        return strlen($this->value) > $this->minLength;
    }

    private function isTooShort(): bool
    {
        return strlen($this->value) < $this->maxLength;
    }

}