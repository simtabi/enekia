<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;
use Exception;

class Username extends AbstractRule implements Rule
{

    public const MIN_LENGTH = 3;
    public const MAX_LENGTH = 36;

    protected int $minLength;
    protected int $maxLength;

    /**
     * The collection of whitelisted usernames
     */
    protected Collection $whitelisted;

    /**
     * The collection of blacklisted usernames
     */
    protected Collection $blacklisted;

    public function __construct(int $minLength = self::MIN_LENGTH, int $maxLength = self::MAX_LENGTH)
    {
        $this->whitelisted = collect(config('enekekia.username.allowed'));
        $this->blacklisted = collect(config('enekekia.username.base'))->merge(config('enekekia.username.blacklisted'));

        $this->setMinLength($minLength)->setMaxLength($maxLength);
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

        $this->setAttribute($attribute)->setValue(strtolower(trim($value)));

        // is too long
        if ($this->isTooLong()) {
            $this->messageKey = 'too_long';
            return false;
        }

        // is too long
        if ($this->isTooShort()) {
            $this->messageKey = 'too_short';
            return false;
        }

        //does not have valid length
        if (!$this->hasValidLength()) {
            $this->messageKey = 'invalid';
            return false;
        }

        // if not correctly formatted
        if (!$this->isFormattedCorrectly($this->value)) {
            $this->messageKey = 'invalid';
            return false;
        }

        // is not allowed
        if ($this->blacklisted->contains($value)) {
            $this->messageKey = 'blacklisted';
            return false;
        }

        // if whitelisted
        if ($this->whitelisted->contains($value)) {
            return true;
        }

        return true;
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
        return (strlen($this->value) >= $this->minLength && strlen($this->value) <= $this->maxLength) ? true : false;
    }

    private function isTooLong(): bool
    {
        return strlen($this->value) > $this->maxLength;
    }

    private function isTooShort(): bool
    {
        return strlen($this->value) < $this->minLength;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        $key = $this->messageKey;
        if (!empty($key)) {
            return __("enekia::messages.$this->attribute.$key", [
                'attribute' => $this->attribute,
            ]);
        }
        return '';
    }
}
