<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Email;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Simtabi\Enekia\Laravel\Models\EmailDomain as EmailDomainModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait EmailDomain
{

    /**
     * @var bool
     */
    protected bool $checkEmailDomainOnSystem = false;

    /**
     * @var bool
     */
    protected bool $checkEmailDomain        = false;

    /**
     * @var string|array
     */
    protected array|string $emailDomains;

    /**
     * @var ?string
     */
    protected ?string $emailDomainColumn = 'domain';

    /**
     * @var bool
     */
    protected bool $strictValidation = true;

    /**
     * @var bool
     */
    protected bool $checkMultipleEmails = false;

    /**
     * @var bool
     */
    protected bool $checkIfEmailHasRestrictedDomains = false;

    /**
     * @var array
     */
    protected array $allowedDomains = [];

    /**
     * @var Collection
     */
    protected Collection $errors;

    public function checkEmailDomainOnSystem(?string $emailDomainColumn = null): static
    {
        $this->checkEmailDomainOnSystem = true;
        $this->emailDomainColumn        = $emailDomainColumn;

        return $this;
    }


    public function checkEmailDomain(array|string $emailDomain, bool $strictValidation = true): static
    {
        $this->checkEmailDomain = true;
        $this->strictValidation = $strictValidation;
        $this->emailDomains     = $emailDomain;

        return $this;
    }

    public function checkMultipleEmails(array|string $emailDomain, bool $strictValidation = true): static
    {
        $this->checkEmailDomain = true;
        $this->strictValidation = $strictValidation;
        $this->emailDomains     = $emailDomain;

        return $this;
    }

    /**
     * @param  array  $allowedDomains
     * @return static
     */
    public function checkIfEmailHasRestrictedDomains(array $allowedDomains): static
    {
        $this->allowedDomains = $allowedDomains;

        return $this;
    }

    public function validateEmailDomain($attribute, $value): bool
    {
        if(is_array($this->emailDomains)) {
            foreach($this->emailDomains as $domain) {
                if($this->check($value, $domain)) return true;
            }
        } else {
            return $this->check($value, $this->emailDomains);
        }

        return false;
    }

    protected function validateEmailDomainOnSystem($attribute, $value): bool
    {
        $emailDomain = Str::lower(Str::after($value, '@'));

        if (empty($emailDomain) || empty($this->emailDomainColumn)) {
            return false;
        }

        /** @var EmailDomainModel $emailDomainModel */
        $emailDomainModel    = app(config('enekia.email_domain.model'));
        $emailDomainWildcard = config('enekia.email_domain.wildcard');

        return $emailDomainModel::query()
            ->where($this->emailDomainColumn, $emailDomain)
            ->orWhereRaw("? LIKE LOWER(REPLACE(domain, '{$emailDomainWildcard}', '%'))", [
                $emailDomain,
            ])
            ->exists();
    }

    public function validateMultipleEmails($attribute, $value): bool
    {
        $emails       = array_map('trim', explode(',', $value));
        $validator    = Validator::make(['emails' => $emails], ['emails.*' => 'email:filter']);
        $this->errors = collect($validator->errors())->map(function ($errors, $key) use ($emails) {
            $key = str_replace('emails.', '', $key);
            return collect($errors)->map(function ($error) use ($emails, $key) {
                return $emails[$key];
            });
        })->flatten();

        return $validator->passes();
    }

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateIfEmailHasRestrictedDomains($attribute, $value): bool
    {

        if (empty($this->allowedDomains))
        {
            return false;
        }

        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return in_array(((string) explode('@', $value)[1]), $this->allowedDomains);
    }

    private function check($value, $validDomain): bool
    {
        $domain = Arr::last(explode('@', $value));

        if(str_contains($validDomain, '*')) {
            return $this->wildcardPasses($domain, $validDomain);
        }

        return $domain === $validDomain;
    }

    private function wildcardPasses($value, $validDomain): bool
    {
        $domain  = str_replace('.', '\.', $validDomain);

        $pattern = $this->strictValidation ? '[^\.\n\r]+' : '.*';
        $regex   = str_replace('*', $pattern, $domain);

        $regex   = '/^' . $regex . '$/';

        return preg_match($regex, $value) === 1;
    }
}