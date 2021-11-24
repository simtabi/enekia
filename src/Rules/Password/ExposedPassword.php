<?php

namespace Simtabi\Enekia\Rules\Password;

use DivineOmega\LaravelPasswordExposedValidationRule\PasswordExposed;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;
use Simtabi\Enekia\Factories\PasswordExposedCheckerFactory;

class ExposedPassword extends AbstractRule implements Rule
{
    /**
     * @var PasswordExposedChecker
     */
    private $passwordExposedChecker;

    /**
     * PasswordExposed constructor.
     *
     * @param PasswordExposedChecker|null $passwordExposedChecker
     */
    public function __construct(PasswordExposedChecker $passwordExposedChecker = null)
    {
        if (!$passwordExposedChecker) {
            $passwordExposedChecker = (new PasswordExposedCheckerFactory())->instance();
        }

        $this->passwordExposedChecker = $passwordExposedChecker;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passwordStatus = $this->passwordExposedChecker->passwordExposed($value);

        return $passwordStatus !== PasswordStatus::EXPOSED;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        return __("ekenia::messages.password.exposed", [
            'attribute' => $this->attribute,
        ]);
    }
}