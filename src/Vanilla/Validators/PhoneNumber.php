<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberToTimeZonesMapper;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;
use Respect\Validation\Validator as Respect;
use Simtabi\Pheg\Core\CoreTools;
use Exception;
use Simtabi\Pheg\Toolbox\Localization\Countries\Countries;

class PhoneNumber
{

    private array|string $errors;

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    /**
     * @return array|string
     */
    public function getErrors(): array|string
    {
        return $this->errors;
    }

    public function isValidCallingCode($value): bool|string
    {
        return Countries::getCallingCode2CountryName($value);
    }

    public function isValidNumber($value, $defaultRegion = CoreTools::DEFAULT_REGION): bool
    {

        // initialize class and assign variable
        $phoneNumberUtility = PhoneNumberUtil::getInstance();
        $phoneNumberObject  = $phoneNumberUtility->parse(str_replace(" ", "", trim($value)), $defaultRegion);

        // validate
        $validNumber        = $phoneNumberUtility->isValidNumber($phoneNumberObject);
        $possibleNumber     = $phoneNumberUtility->isPossibleNumber($phoneNumberObject);

        // if valid and possible number
        if($validNumber && $possibleNumber){
            return true;
        }

        // if not a possible number
        if (!$possibleNumber){
            $this->errors[] = 'NOT_A_POSSIBLE_PHONE_NUMBER';
            return false;
        }

        // if not a valid number
        if (!$validNumber){
            $this->errors[] = 'INVALID_PHONE_NUMBER';
            return false;
        }

        return false;
    }

}
