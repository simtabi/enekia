<?php

namespace Simtabi\Enekia\Laravel\Rules\DateAndTime;

use DateTime;
use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\DateTime as DT;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\ExtendedRFC3339;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\Interval;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\MaximumHourDifference;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\PositiveDateInterval;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\Time12Hour;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\Time24Hour;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\TimeZoneAbbr;
use Simtabi\Enekia\Laravel\Traits\Rules\DateAndTime\UnixTime;

class DateAndTime extends AbstractRule implements Rule
{

    use DT;
    use ExtendedRFC3339;
    use Interval;
    use PositiveDateInterval;
    use MaximumHourDifference;
    use Time12Hour;
    use Time24Hour;
    use TimeZoneAbbr;
    use UnixTime;

    public function __construct()
    {
        $this->parameters = func_get_args();

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $this->grabRuleData($attribute, $value);

        if ($this->checkTime12Hour){
            return $this->validateTime12Hour($attribute, $value);
        }elseif ($this->checkTime24Hour){
            return $this->validateTime24Hour($attribute, $value);
        }elseif ($this->checkTimeZoneAbbr){
            return $this->validateTimeZoneAbbr($attribute, $value);
        }elseif ($this->checkUnixTime){
            return $this->validateUnixTime($attribute, $value);
        }elseif ($this->checkPositiveDateInterval){
            return $this->validatePositiveDateInterval($attribute, $value);
        }elseif ($this->checkMaximumHourDifference){
            return $this->validateMaximumHourDifference($attribute, $value);
        }elseif ($this->checkExtendedRFC3339){
            return $this->validateExtendedRFC3339($attribute, $value);
        }elseif ($this->checkDateTime){
            return $this->validateDateTime($attribute, $value);
        }elseif ($this->checkIfIsInterval){
            return $this->validateInterval($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkTime12Hour){
            return [
                'key'        => 'date_and_time.time_12_hour',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'format'    => $this->getTime12HourFormat(),
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkTime24Hour){
            return [
                'key'        => 'date_and_time.time_24_hour',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'format'    => $this->getTime24HourFormat(),
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkTimeZoneAbbr){
            return [
                'key'        => 'date_and_time.timezone_abbr',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkUnixTime){
            return [
                'key'        => 'date_and_time.unix_time',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkPositiveDateInterval){
            return [
                'key'        => 'date_and_time.positive_interval',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkMaximumHourDifference){
            return [
                'key'        => 'date_and_time.maximum_hour_difference',
                'parameters' => [
                    'attribute'  => $this->attribute,
                    'difference' => $this->hours,
                ],
            ];
        }elseif ($this->checkExtendedRFC3339){
            return [
                'key'        => 'date_and_time.extended_rfc3339',
                'parameters' => [
                    'attribute'  => $this->attribute,
                    'difference' => $this->hours,
                ],
            ];
        }else        if ($this->checkAfterOrEqual){
            return [
                'key'        => 'date_and_time.after_or_equal',
                'parameters' => [
                    'after_or_equal' => $this->date->format(DateTime::ATOM), // $this->date->format(DateTimeInterface::ISO8601)
                ],
            ];
        }elseif ($this->checkBeforeOrEqual){
            return [
                'key'        => 'date_and_time.before_or_equal',
                'parameters' => [
                    'attribute'       => $this->attribute,
                    'before_or_equal' => $this->date->format(DateTime::ATOM), // $this->date->format(DateTimeInterface::ISO8601)
                ],
            ];
        }elseif ($this->checkIfHasSpecificMinutes){
            return [
                'key'        => 'date_and_time.has_specific_minutes',
                'parameters' => [
                    'attribute'            => $this->attribute,
                    'has_specific_minutes' => implode(', ', $this->allowedMinutes),
                ],
            ];
        }elseif ($this->checkIfIsInterval){
            return [
                'key'        => 'date_and_time.interval',
                'parameters' => [
                    'attribute'  => $this->attribute,
                ],
            ];
        }

        return '';
    }
}