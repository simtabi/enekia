<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Simtabi\Enekia\Laravel\Models\PasswordHistoryRepo;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use DivineOmega\PasswordExposed\Enums\PasswordStatus;
use DivineOmega\PasswordExposed\PasswordExposedChecker;
use Simtabi\Enekia\Laravel\Validators\Password\Zxcvbn;

class Password extends AbstractRule implements Rule
{

    /**
     * The minimum length of the password.
     *
     * @var int
     */
    protected int $minLength = 8;

    /**
     * The maximum length of the password.
     *
     * @var int
     */
    protected int $maxLength = 32;

    /**
     * Indicates if the password must contain one uppercase character.
     *
     * @var bool
     */
    protected bool $requireUppercaseCharacters = false;

    /**
     * Indicates if the password must contain one numeric digit.
     *
     * @var bool
     */
    protected bool $requireNumerics            = false;

    /**
     * Indicates if the password must contain one special character.
     *
     * @var bool
     */
    protected bool $requireSpecialCharacters   = false;

    /**
     * If password strength should be validated
     *
     * @var bool
     */
    protected bool  $checkIfIsStrong           = false;

    /**
     * Store ZXCVBN password strength arguments
     *
     * @var array
     */
    protected array $zxcvbnArgs;

    /**
     * ZXCVBN password strength
     *
     * @var int
     */
    protected int   $zxcvbnScore       = 4;

    /**
     * ZXCVBN error message key verbosity
     *
     * @var bool
     */
    protected bool  $zxcvbnVerbosity   = false;

    /**
     * If password strength is weak
     *
     * @var bool
     */
    protected bool $weakPassword       = false;

    /**
     * If password has been exposed in a data breach
     *
     * @var bool
     */
    protected bool $checkIfExposed     = false;

    /**
     * If password has been used before
     *
     * @var bool
     */
    protected bool $checkIfUsedBefore  = false;

    /**
     * @var PasswordExposedChecker
     */
    protected PasswordExposedChecker $passwordExposedChecker;

    /**
     * @var Model|Guard|StatefulGuard|Authenticatable
     */
    protected Model|Guard|StatefulGuard|Authenticatable $user;

    /**
     * PasswordExposed constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
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
        $value = is_scalar($value) ? (string) $value : '';

        // check empty
        if (!trim($value))
        {
            return false;
        }

        if ($this->checkIfExposed){
            return $this->passwordExposedChecker->passwordExposed($value) !== PasswordStatus::EXPOSED;
        }else{

            if ($this->checkIfUsedBefore)
            {
                $passwordHistories = PasswordHistoryRepo::fetchUser($this->user, config('enekia.password_history.max_count'));
                foreach ($passwordHistories as $passwordHistory) {
                    if (Hash::check($value, $passwordHistory->password)) {
                        return false;
                    }
                }

                return true;
            }

            if ($this->requireUppercaseCharacters && Str::lower($value) === $value) {
                return false;
            }

            if ($this->requireNumerics && ! preg_match('/[0-9]/', $value)) {
                return false;
            }

            if ($this->requireSpecialCharacters && ! preg_match('/[\W_]/', $value)) {
                return false;
            }

            if ($this->checkIfIsStrong && !$this->isStrong($value))
            {
                $this->weakPassword = true;

                return false;
            }

            return Str::length($value) >= $this->minLength;
        }

    }

    /**
     * Set the minimum length of the password.
     *
     * @param  int  $length
     * @return static
     */
    public function length(int $length): static
    {
        $this->minLength = $length;

        return $this;
    }

    /**
     * Indicate that at least one uppercase character is required.
     *
     * @return static
     */
    public function requireUppercase(): static
    {
        $this->requireUppercaseCharacters = true;

        return $this;
    }

    /**
     * Indicate that at least one numeric digit is required.
     *
     * @return static
     */
    public function requireNumeric(): static
    {
        $this->requireNumerics = true;

        return $this;
    }

    /**
     * Indicate that at least one special character is required.
     *
     * @return static
     */
    public function requireSpecialCharacter(): static
    {
        $this->requireSpecialCharacters = true;

        return $this;
    }

    /**
     * Validate password strength
     *
     * @param int $desiredStrength
     * @param string|null $email
     * @param string|null $username
     * @param bool $verbose
     * @return static
     */
    public function checkStrength(int $desiredStrength = 4, ?string $email = null, ?string $username = null, bool $verbose = false): static
    {
        $this->zxcvbnVerbosity = $verbose;
        $this->checkIfIsStrong = true;
        $this->zxcvbnArgs      = [$username, $email];
        $this->zxcvbnScore     = $desiredStrength;

        return $this;
    }

    /**
     * Check if password has been exposed in a data breach

     * @param PasswordExposedChecker|null $passwordExposedChecker
     * @return static
     */
    public function checkIfExposedInDataBreach(PasswordExposedChecker $passwordExposedChecker = null): static
    {
        if (!$passwordExposedChecker) {
            $passwordExposedChecker = (new PasswordExposedCheckerFactory())->instance();
        }

        $this->passwordExposedChecker = $passwordExposedChecker;
        $this->checkIfExposed         = true;

        return $this;
    }

    /**
     * Check if password has been used before on the given user
     *
     * @param Model|Guard|StatefulGuard|Authenticatable $user
     * @return static
     */
    public function checkIfUsedBefore(Model|Guard|StatefulGuard|Authenticatable $user): static
    {
        $this->checkIfExposed = true;
        $this->user           = $user;

        return $this;
    }

    public function isStrong($value): bool
    {
        // Password must be at least x characters long
        if (Str::length($value) < $this->minLength)
        {
            return false;
        }

        // Password must contain at least one capital character
        elseif (!preg_match('/[A-Z]/', $value))
        {
            return false;
        }

        // Password must contain at least one lower case character
        elseif (!preg_match('/[a-z]/', $value))
        {
            return false;
        }

        // Password must contain at least one number
        elseif(!preg_match('/\d/', $value))
        {
            return false;
        }

        elseif(!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $value))
        {
            return false;
        }

        // Determine if the validation rule passes.
        // The password must be 12 - 30 characters in length, and include a number, a symbol, an upper case letter,
        // and a lower case letter.
        elseif (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@()$%^&*=_{}[\]:;"\'|\\<>,.\/~`±§+-]).{12,30}$/', $value) > 0){
            return false;
        }

        $zxcvbn   = new Zxcvbn($this->zxcvbnVerbosity);
        $validate =  $zxcvbn->validate($value, $this->zxcvbnScore, $this->zxcvbnArgs[0], $this->zxcvbnArgs[1]);

        $this->messageKey = $zxcvbn->getMessageKey();

        return $validate;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array|null
     */
    public function getMessageKey(): string|null|array
    {

        return match (true) {
            $this->requireUppercaseCharacters && !$this->requireNumerics && !$this->requireSpecialCharacters => [
                'key'        => 'password.uppercase_character_required',
                'parameters' => [
                    'length' => $this->minLength,
                ],
            ],

            $this->requireNumerics && !$this->requireUppercaseCharacters && !$this->requireSpecialCharacters => [
                'key'        => 'password.number_required',
                'parameters' => [
                    'length' => $this->minLength,
                ],
            ],

            $this->requireSpecialCharacters && !$this->requireUppercaseCharacters && !$this->requireNumerics => [
                'key'        => 'password.special_character_required',
                'parameters' => [
                    'length' => $this->minLength,
                ],
            ],

            $this->requireUppercaseCharacters && $this->requireNumerics && !$this->requireSpecialCharacters => [
                'key'        => 'password.uppercase_character_number_required',
                'parameters' => [
                    'length' => $this->minLength,
                ],
            ],

            $this->requireUppercaseCharacters && $this->requireSpecialCharacters && !$this->requireNumerics => [
                'key'        => 'password.uppercase_character_special_character_required',
                'parameters' => [
                    'length' => $this->minLength,
                ],
            ],

            $this->requireUppercaseCharacters && $this->requireNumerics && $this->requireSpecialCharacters => [
                'key'        => 'password.uppercase_character_number_special_character_required',
                'parameters' => [
                    'length' => $this->minLength,
                ],
            ],

            $this->requireNumerics && $this->requireSpecialCharacters && !$this->requireUppercaseCharacters => [
                'key'        => 'password.number_special_character_required',
                'parameters' => [
                    'length' => $this->minLength,
                ],
            ],

            $this->checkIfIsStrong   => [
                'key'        => $this->messageKey,
                'parameters' => [

                ],
            ],

            $this->weakPassword   => [
                'key'        => 'password.weak_password',
                'parameters' => [
                    'min' => $this->minLength,
                    'max' => $this->maxLength,
                ],
            ],

            $this->checkIfExposed    => [
                'key'        => 'password.is_exposed',
                'parameters' => [],
            ],

            $this->checkIfUsedBefore => [
                'key'        => 'password.has_been_used',
                'parameters' => [],
            ],

            default => [
                'key'        => 'password.length',
                'parameters' => [
                    'length' => $this->minLength,
                ],
            ],

        };
    }
}