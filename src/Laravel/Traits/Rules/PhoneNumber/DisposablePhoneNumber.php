<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Traits\Rules\PhoneNumber;

use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\API\VerifyDomainFromMailcheckApi;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Facades\DisposableDomainFacade;
use Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\DisposablePhoneNumber;

trait DisposablePhoneNumber
{

    protected bool $checkIfIsDisposablePhoneNumber    = false;
    protected bool $verifyViaPizzaValidationApi = false;

    public function checkIfIsDisposablePhoneNumber(): static
    {
        $this->checkIfIsDisposablePhoneNumber = true;

        return $this;
    }

    public function verifyViaPizzaValidationApi(): static
    {
        $this->verifyViaPizzaValidationApi = true;

        return $this;
    }
    
    public function validateDisposablePhoneNumber($attribute, $value) : bool
    {
        return DisposablePhoneNumber::isNotDisposable($value);
    }

}
