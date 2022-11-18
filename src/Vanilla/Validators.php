<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Carbon\Carbon;
use Respect\Validation\Validator as Respect;
use Simtabi\Enekia\Vanilla\Validators\Age;
use Simtabi\Enekia\Vanilla\Validators\Colors;
use Simtabi\Enekia\Vanilla\Validators\Country;
use Simtabi\Enekia\Vanilla\Validators\Gravatar;
use Simtabi\Enekia\Vanilla\Validators\Time;
use Simtabi\Enekia\Vanilla\Validators\File;
use Simtabi\Enekia\Vanilla\Validators\Email;
use Simtabi\Enekia\Vanilla\Validators\Html;
use Simtabi\Enekia\Vanilla\Validators\IpAddress;
use Simtabi\Enekia\Vanilla\Validators\Password;
use Simtabi\Enekia\Vanilla\Validators\PhoneNumber;
use Simtabi\Enekia\Vanilla\Validators\PostalCode;
use Simtabi\Enekia\Vanilla\Validators\Str;
use Simtabi\Enekia\Vanilla\Validators\Transfigure;
use Simtabi\Enekia\Vanilla\Validators\Url;
use Simtabi\Enekia\Vanilla\Validators\Username;
use Simtabi\Enekia\Vanilla\Validators\VersionNumber;
use Simtabi\Enekia\Vanilla\Validators\Xml;

final class Validators
{

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    public function age(): Age
    {
        return new Age();
    }

    public function colors(): Colors
    {
        return new Colors();
    }

    public function country(): Country
    {
        return new Country;
    }

    public function email(): Email
    {
        return new Email;
    }

    public function file(): File
    {
        return new File;
    }

    public function html(): Html
    {
        return new Html;
    }

    public function ipAddress(): IpAddress
    {
        return new IpAddress;
    }

    public function password(): Password
    {
        return new Password;
    }

    public function phoneNumber(): PhoneNumber
    {
        return new PhoneNumber;
    }

    public function postalCode(): PostalCode
    {
        return new PostalCode;
    }

    public function str(): Str
    {
        return new Str;
    }

    public function time(Carbon $carbon = null, $timezone = null): Time
    {
        return new Time($carbon, $timezone);
    }

    public function transfigure(): Transfigure
    {
        return new Transfigure();
    }

    public function url(): Url
    {
        return new Url;
    }

    public function username(): Username
    {
        return new Username;
    }

    public function versionNumber(): VersionNumber
    {
        return new VersionNumber;
    }

    public function xml(): Xml
    {
        return new Xml();
    }

    public function gravatar(): Gravatar
    {
        return new Gravatar();
    }

}





