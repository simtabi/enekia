<?php declare(strict_types=1);

namespace Simtabi\Enekia;

use Carbon\Carbon;
use Simtabi\Enekia\Validators\AgeValidator;
use Simtabi\Enekia\Validators\ArrayValidator;
use Simtabi\Enekia\Validators\ColorValidator;
use Simtabi\Enekia\Validators\CountryValidator;
use Simtabi\Enekia\Validators\TimeValidator;
use Simtabi\Enekia\Validators\FileSystemValidator;
use Simtabi\Enekia\Validators\EmailValidator;
use Simtabi\Enekia\Validators\HtmlValidator;
use Simtabi\Enekia\Validators\IpAddressValidator;
use Simtabi\Enekia\Validators\JsonValidator;
use Simtabi\Enekia\Validators\NumberValidator;
use Simtabi\Enekia\Validators\PasswordValidator;
use Simtabi\Enekia\Validators\PhoneNumberValidator;
use Simtabi\Enekia\Validators\PostalCodeValidator;
use Simtabi\Enekia\Validators\StringValidator;
use Simtabi\Enekia\Validators\TypeValidator;
use Simtabi\Enekia\Validators\UrlValidator;
use Simtabi\Enekia\Validators\UsernameValidator;
use Simtabi\Enekia\Validators\VersionNumberValidator;
use Simtabi\Enekia\Validators\XmlValidator;
use Simtabi\Enekia\Validators\Traits\WithGeneralValidatorsTrait;
use Simtabi\Enekia\Validators\Traits\WithRespectValidationTrait;

final class Validators
{

    use WithRespectValidationTrait;
    use WithGeneralValidatorsTrait;

    public function __construct()
    {

    }

    public static function invoke(): self
    {
        return new self();
    }

    public function age(): AgeValidator
    {
        return new AgeValidator();
    }

    public function array(): ArrayValidator
    {
        return new ArrayValidator();
    }

    public function color(): ColorValidator
    {
        return new ColorValidator();
    }

    public function country(): CountryValidator
    {
        return new CountryValidator();
    }

    public function email(): EmailValidator
    {
        return new EmailValidator();
    }

    public function fileSystem(): FileSystemValidator
    {
        return new FileSystemValidator();
    }

    public function html(): HtmlValidator
    {
        return new HtmlValidator();
    }

    public function ipAddress(): IpAddressValidator
    {
        return new IpAddressValidator();
    }

    public function number(): NumberValidator
    {
        return new NumberValidator();
    }

    public function password(): PasswordValidator
    {
        return new PasswordValidator();
    }

    public function phoneNumber(): PhoneNumberValidator
    {
        return new PhoneNumberValidator();
    }

    public function postalCode(): PostalCodeValidator
    {
        return new PostalCodeValidator();
    }

    public function string(): StringValidator
    {
        return new StringValidator();
    }

    public function time(Carbon $carbon, $timezone = null): TimeValidator
    {
        return new TimeValidator($carbon, $timezone);
    }

    public function dataType(): TypeValidator
    {
        return TypeValidator::invoke();
    }

    public function url(): UrlValidator
    {
        return new UrlValidator();
    }

    public function username(): UsernameValidator
    {
        return new UsernameValidator();
    }

    public function versionNumber(): VersionNumberValidator
    {
        return new VersionNumberValidator();
    }

    public function xml(): XmlValidator
    {
        return new XmlValidator();
    }

}





