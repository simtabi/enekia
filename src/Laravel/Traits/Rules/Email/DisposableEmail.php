<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Traits\Rules\Email;

use GuzzleHttp\Client;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\API\VerifyDomainFromMailcheckApi;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Facades\DisposableDomainFacade;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;

trait DisposableEmail
{

    protected bool $checkIfIsDisposableEmail       = false;
    protected bool $verifyViaMailcheckValidatorApi = false;
    protected bool $verifyViaMailGunApi            = false;
    protected bool $verifyViaEguliasEmailValidator = false;

    public function checkIfIsDisposableEmail(): static
    {
        $this->checkIfIsDisposableEmail = true;

        return $this;
    }

    public function verifyViaMailcheckValidatorApi(): static
    {
        $this->verifyViaMailcheckValidatorApi = true;

        return $this;
    }

    public function verifyViaMailGunApi(): static
    {
        $this->verifyViaMailGunApi = true;

        return $this;
    }

    public function verifyViaEguliasEmailValidator(): static
    {
        $this->verifyViaEguliasEmailValidator = true;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * By default, if the API fails to load, the email will
     * be accepted. However, you can override this by adding
     * a boolean parameter e.g. new DisposableEmail(true).
     *
     **/
    public function validateDisposableEmail($attribute, $value) : bool
    {
        if ($this->verifyViaMailcheckValidatorApi){
            return (new VerifyDomainFromMailcheckApi())->checkEmail($value);
        }elseif ($this->verifyViaMailGunApi){
            $response = (new Client())->get('https://api.mailgun.net/v3/address/validate', [
                'query' => [
                    'address' => $value,
                    'api_key' => env('MAILGUN_API_KEY'),
                ],
                'auth'   => null,
            ]);

            return json_decode($response->getBody()->getContents())->is_valid;
        }elseif ($this->verifyViaEguliasEmailValidator){
            return (new EmailValidator())->isValid($value, new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation(),
                new SpoofCheckValidation(),
            ]));
        }

        return DisposableDomainFacade::isNotDisposable($value);
    }

}
