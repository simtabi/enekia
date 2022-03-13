<?php declare(strict_types=1);

namespace Simtabi\Enekia;

use Carbon\Carbon;
use Respect\Validation\Validator as Respect;
use Simtabi\Enekia\Validators\Age;
use Simtabi\Enekia\Validators\Colors;
use Simtabi\Enekia\Validators\Country;
use Simtabi\Enekia\Validators\Time;
use Simtabi\Enekia\Validators\File;
use Simtabi\Enekia\Validators\Email;
use Simtabi\Enekia\Validators\Html;
use Simtabi\Enekia\Validators\IpAddress;
use Simtabi\Enekia\Validators\Password;
use Simtabi\Enekia\Validators\PhoneNumber;
use Simtabi\Enekia\Validators\PostalCode;
use Simtabi\Enekia\Validators\Str;
use Simtabi\Enekia\Validators\Transfigure;
use Simtabi\Enekia\Validators\Url;
use Simtabi\Enekia\Validators\Username;
use Simtabi\Enekia\Validators\VersionNumber;
use Simtabi\Enekia\Validators\Xml;

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

    public function arr(): Arr
    {
        return new Arr;
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
        return (new Xml());
    }

}





