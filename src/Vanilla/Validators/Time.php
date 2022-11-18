<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Carbon\Carbon;
use Respect\Validation\Validator as Respect;
use Simtabi\Pheg\Pheg;

class Time
{

    /**
     * The Carbon time instance.
     *
     * @var Carbon
     */
    protected $carbon;

    /**
     * The difference in seconds between the Carbon time and current time.
     *
     * @var int
     */
    protected $diffInSeconds;

    /**
     * The timezone that will be used.
     *
     * @var string
     */
    protected $timezone;

    private Pheg $pheg;

    /**
     * Create a new Parser instance.
     *
     * @param Carbon|null $carbon
     * @param null $timezone
     */
    public function __construct(Carbon $carbon = null, $timezone = null)
    {
        $this->timezone = $timezone;
        $this->carbon   = $carbon;
        $this->pheg     = Pheg::getInstance();
    }

    public function respect(): Respect
    {
        return new Respect();
    }

    /**
     * Determine if the difference is more than a minute.
     *
     * @return bool
     */
    protected function isMoreThanAMinute()
    {
        return $this->carbon->diffInSeconds >= 60;
    }
    
    /**
     * Determine if the difference is more than a hour.
     *
     * @return bool
     */
    protected function isMoreThanAHour()
    {
        return $this->diffInSeconds >= 3600;
    }
    
    /**
     * Determine if the difference is more than a day.
     *
     * @return bool
     */
    protected function isMoreThanADay()
    {
        return $this->diffInSeconds >= 86400;
    }
    
    /**
     * Determine if the difference is more than a week.
     *
     * @return bool
     */
    protected function isMoreThanAWeek()
    {
        return $this->diffInSeconds >= 604800;
    }
    
    /**
     * Determine if the Carbon time's year is different with current year.
     *
     * @return bool
     */
    protected function isTheYearDifferent()
    {
        return $this->carbon->year !== Carbon::now($this->timezone)->year;
    }

    public function isDateFormat($value = null, $format = 'MM/DD/YYYY')
    {
        // Datetime validation from http://www.phpro.org/examples/Validate-Date-Using-PHP.html
        if (empty($value)) {
            return false;
        }

        $format = match ($format) {
            'YYYY/MM/DD', 'YYYY-MM-DD' => 1,
            'YYYY/DD/MM', 'YYYY-DD-MM' => 2,
            'DD/MM/YYYY', 'DD-MM-YYYY' => 3,
            'MM/DD/YYYY', 'MM-DD-YYYY' => 4,
            'YYYYMMDD'                 => 5,
            'YYYYDDMM'                 => 6,
        };

        if ($format === 1) {
            list($y, $m, $d) = preg_split('/[-\.\/ ]/', $value);
        }elseif ($format === 2) {
            list($y, $d, $m) = preg_split('/[-\.\/ ]/', $value);
        }elseif ($format === 3) {
            list($d, $m, $y) = preg_split('/[-\.\/ ]/', $value);
        }elseif ($format === 4) {
            list($m, $d, $y) = preg_split('/[-\.\/ ]/', $value);
        }elseif ($format === 5) {
            $y = substr($value, 0, 4);
            $m = substr($value, 4, 2);
            $d = substr($value, 6, 2);
        }elseif ($format === 6) {
            $y = substr($value, 0, 4);
            $d = substr($value, 4, 2);
            $m = substr($value, 6, 2);
        }else{
            return false;
        }

        return checkdate($m, $d, $y);
    }

    public function isTimestamp($timestamp)
    {
        $check = function ($timestamp){
            $check = (is_int($timestamp) || is_float($timestamp)) ? $timestamp : (string) (int) $timestamp;
            return (bool) (($check === $timestamp) && (( (int) $timestamp <=  PHP_INT_MAX) && ( (int) $timestamp >= ~PHP_INT_MAX)));
        };

        return $check($timestamp) || (strtotime(date('d-m-Y H:i:s', $timestamp)) === (int)$timestamp);
    }

    public function isZeroDate($value): bool
    {
        // http://stackoverflow.com/questions/8853956/check-if-date-is-equal-to-0000-00-00-000000
        if(empty($value)){
            $value = '0000-00-00';
        }

        return match (trim($value)) {
            '0000-00-00 00:00:00', '0000-00-00' => true,
            default                             => false,
        };
    }

    public function isDateTime($value, $format = 'Y-m-d H:i:s'): bool
    {
        return $this->isDate($value, $format);
    }

    public function isDate($value, $format = 'Y-m-d'): bool
    {
        if(!empty($format)){
            if($this->respect()->date($format)->validate($value)){
                return true;
            }
        }elseif($this->respect()->date()->validate($value)){
            return true;
        }
        return false;
    }

    public function isYear($value): bool
    {
        return $this->respect()->date('Y')->validate($value);
    }

    public function isTimezone($value): bool
    {
        return  in_array($value, timezone_identifiers_list());
    }

    /**
     * Check if string is date or time
     *
     * @param string|null $date
     * @return bool
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function isDateOrTime(?string $date): bool
    {
        return strtotime((string)$date) > 0;
    }

    /**
     * Returns true if date passed is within this week.
     *
     * @param int|string $time
     * @return bool
     */
    public function isThisWeek(int|string $time): bool
    {
        return ($this->pheg->time()->factory($time)->format('W-Y') === $this->pheg->time()->factory()->format('W-Y'));
    }

    /**
     * Returns true if date passed is within this month.
     *
     * @param string|int $time
     * @return bool
     */
    public function isThisMonth($time): bool
    {
        return ($this->pheg->time()->factory($time)->format('m-Y') === $this->pheg->time()->factory()->format('m-Y'));
    }

    /**
     * Returns true if date passed is within this year.
     *
     * @param string|int $time
     * @return bool
     */
    public function isThisYear($time): bool
    {
        return ($this->pheg->time()->factory($time)->format('Y') === $this->pheg->time()->factory()->format('Y'));
    }

    /**
     * Returns true if date passed is tomorrow.
     *
     * @param string|int $time
     * @return bool
     */
    public function isTomorrow($time): bool
    {
        return ($this->pheg->time()->factory($time)->format('Y-m-d') === $this->pheg->time()->factory('tomorrow')->format('Y-m-d'));
    }

    /**
     * Returns true if date passed is today.
     *
     * @param string|int $time
     * @return bool
     */
    public function isToday($time): bool
    {
        return ($this->pheg->time()->factory($time)->format('Y-m-d') === $this->pheg->time()->factory()->format('Y-m-d'));
    }

    /**
     * Returns true if date passed was yesterday.
     *
     * @param string|int $time
     * @return bool
     */
    public function isYesterday($time): bool
    {
        return ($this->pheg->time()->factory($time)->format('Y-m-d') === $this->pheg->time()->factory('yesterday')->format('Y-m-d'));
    }

    public function isDateGreater($date, $defaultDate = ''): bool
    {
        $default = empty($defaultDate) ? strtotime($this->pheg->time()->getCurrentTime()) : strtotime($defaultDate);

        return strtotime($date) > $default;
    }
}
