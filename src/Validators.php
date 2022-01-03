<?php declare(strict_types=1);

namespace Simtabi\Enekia;

use Carbon\Carbon;
use Simtabi\Enekia\Validators\Age;
use Simtabi\Enekia\Validators\Arr;
use Simtabi\Enekia\Validators\Colors;
use Simtabi\Enekia\Validators\Country;
use Simtabi\Enekia\Validators\Time;
use Simtabi\Enekia\Validators\File;
use Simtabi\Enekia\Validators\Email;
use Simtabi\Enekia\Validators\Html;
use Simtabi\Enekia\Validators\IpAddress;
use Simtabi\Enekia\Validators\Transfigure;
use Simtabi\Enekia\Validators\Vars;
use Simtabi\Enekia\Validators\Password;
use Simtabi\Enekia\Validators\PhoneNumber;
use Simtabi\Enekia\Validators\PostalCode;
use Simtabi\Enekia\Validators\Str;
use Simtabi\Enekia\Validators\Url;
use Simtabi\Enekia\Validators\Username;
use Simtabi\Enekia\Validators\VersionNumber;
use Simtabi\Enekia\Validators\Xml;
use Simtabi\Enekia\Validators\Traits\WithRespectValidationTrait;

final class Validators
{

    use WithRespectValidationTrait;

    public function __construct()
    {

    }

    public static function invoke(): self
    {
        return new self();
    }

    public function age(): Age
    {
        return Age::invoke();
    }

    public function arr(): Arr
    {
        return Arr::invoke();
    }

    public function colors(): Colors
    {
        return Colors::invoke();
    }

    public function country(): Country
    {
        return Country::invoke();
    }

    public function email(): Email
    {
        return Email::invoke();
    }

    public function file(): File
    {
        return File::invoke();
    }

    public function html(): Html
    {
        return Html::invoke();
    }

    public function ipAddress(): IpAddress
    {
        return IpAddress::invoke();
    }

    public function vars(): Vars
    {
        return Vars::invoke();
    }

    public function password(): Password
    {
        return Password::invoke();
    }

    public function phoneNumber(): PhoneNumber
    {
        return PhoneNumber::invoke();
    }

    public function postalCode(): PostalCode
    {
        return PostalCode::invoke();
    }

    public function str(): Str
    {
        return Str::invoke();
    }

    public function time(Carbon $carbon = null, $timezone = null): Time
    {
        return Time::invoke($carbon, $timezone);
    }

    public function transfigure(): Transfigure
    {
        return Transfigure::invoke();
    }

    public function url(): Url
    {
        return Url::invoke();
    }

    public function username(): Username
    {
        return Username::invoke();
    }

    public function versionNumber(): VersionNumber
    {
        return VersionNumber::invoke();
    }

    public function xml(): Xml
    {
        return Xml::invoke();
    }

}





