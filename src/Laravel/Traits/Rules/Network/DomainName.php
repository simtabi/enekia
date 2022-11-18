<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\API\VerifyDomainFromMailcheckApi;

trait DomainName
{

    /**
     * @var bool
     */
    protected bool $checkIfIsDomainName = false;

    /**
     * @var bool
     */
    protected bool $checkIfIsDisposableDomainName = false;

    /**
     * @var bool
     */
    protected bool $verifyViaMailcheckValidationApi = false;

    /**
     * @return static
     */
    public function checkIfIsDomainName(): static
    {
        $this->checkIfIsDomainName = true;

        return $this;
    }

    /**
     * @return static
     */
    public function checkIfIsDisposableDomainName(): static
    {
        $this->checkIfIsDisposableDomainName = true;

        return $this;
    }

    public function verifyViaMailcheckValidationApi(): static
    {
        $this->verifyViaMailcheckValidationApi = true;

        return $this;
    }

    public function validateDomainName($attribute, $value): bool
    {

        $validate = function () use ($value) {
            $labels = $this->getLabels($value); // get labels of domainname
            $tld = end($labels); // most right label of domainname is tld

            // domain must have 2 labels minimum
            if (count($labels) <= 1) {
                return false;
            }

            // each label must be valid
            foreach ($labels as $label) {
                if (! $this->isValidLabel($label)) {
                    return false;
                }
            }

            // tld must be valid
            if (! $this->isValidTld($tld)) {
                return false;
            }

            return true;
        };

        if ($this->checkIfIsDisposableDomainName){
            if ($this->verifyViaMailcheckValidationApi){
                return (new VerifyDomainFromMailcheckApi())->checkDomain($value);
            }
        }

        return $validate() || ((Str::of($value))->match('/^((?!-)[A-Za-z0-9-]{1,63}(?<!-)\\.)+[A-Za-z]{2,6}$/')->length() !== 0);
    }













    /**
     * Get all labels of a domain name
     *
     * @param $value
     * @return array
     */
    private function getLabels($value): array
    {
        return explode('.', $this->idnToAscii($value));
    }

    /**
     * Determine if given string is valid idn label
     *
     * @param  string  $value
     * @return boolean
     */
    private function isValidLabel(string $value): bool
    {
        return $this->isValidALabel($value) || $this->isValidNrLdhLabel($value);
    }

    /**
     * Determine if given value is valid A-Label
     *
     * Begins with "xn--" and is resolvable by PunyCode algorithm
     *
     * @param  string  $value
     * @return boolean
     */
    private function isValidALabel(string $value): bool
    {
        return substr($value, 0, 4) === 'xn--' && $this->idnToUtf8($value) !== false;
    }

    /**
     * Determine if given value is valued NR-LDH label
     *
     * @param  string  $value
     * @return boolean
     */
    private function isValidNrLdhLabel(string $value): bool
    {
        return (bool) preg_match("/^(?!\-)[a-z0-9\-]{1,63}(?<!\-)$/i", $value);
    }

    /**
     * Determine if given value is valid TLD
     *
     * @param  string  $value
     * @return boolean
     */
    private function isValidTld(string $value): bool
    {
        if ($this->isValidALabel($value)) {
            return true;
        }

        return (bool) preg_match("/^[a-z]{2,63}$/i", $value);
    }

    /**
     * Wrapper method for idn_to_utf8 call
     *
     * @param  string $domain
     * @return string
     */
    private function idnToUtf8(string $domain): string
    {
        return idn_to_utf8($domain, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
    }

    /**
     * Wrapper method for idn_to_ascii call
     *
     * @param  string $domain
     * @return string
     */
    private function idnToAscii(string $domain): string
    {
        return idn_to_ascii($domain, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
    }

}
