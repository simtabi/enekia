<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Respect\Validation\Validator as Respect;
use Simtabi\Pheg\Toolbox\Arr\Arr as PhegArr;
use Simtabi\Pheg\Toolbox\Serialize;
use stdClass;

class Transfigure
{

    public function __construct() {}

    public function respect(): Respect
    {
        return new Respect();
    }

    public function isNotANumber(int $number): bool
    {
        $number = !empty($number) && (is_integer($number) || is_numeric($number) || is_float($number)) ? (float) $number : 0;

        return $number === 0;
    }

    /**
     * Returns true if the number is within the min and max.
     *
     * @param float $number
     * @param float $min
     * @param float $max
     * @return bool
     */
    public function isInMixAndMax(float $number, float $min, float $max): bool
    {
        return ($number >= $min && $number <= $max);
    }

    /**
     * Is the current value even?
     *
     * @param int $number
     * @return bool
     */
    public function isEven(int $number): bool
    {
        return ($number % 2 === 0);
    }

    /**
     * Is the current value negative; less than zero.
     *
     * @param float $number
     * @return bool
     */
    public function isNegative(float $number): bool
    {
        return ($number < 0);
    }

    /**
     * Is the current value odd?
     *
     * @param int $number
     * @return bool
     */
    public function isOdd(int $number): bool
    {
        return !$this->isEven($number);
    }

    /**
     * Is the current value positive; greater than or equal to zero.
     *
     * @param float $number
     * @param bool  $zero
     * @return bool
     */
    public function isPositive(float $number, bool $zero = true): bool
    {
        return ($zero ? ($number >= 0) : ($number > 0));
    }

    /**
     * Check if number is odd
     * @param  int  $num integer to check
     * @return boolean
     */
    public function isNumberOdd($num) {
        return (($num - (2 * floor($num / 2))) == 1);
    }

    /**
     * Check if number is even
     * @param  int  $num integer to check
     * @return boolean
     */
    public function isNumberEven($num) {
        return (($num - (2 * floor($num / 2))) == 0);
    }

    public function minLength($value = null, $minimum = 0): bool
    {
        if($this->respect()->stringType()->length($minimum, null)->validate($value)){
            return true;
        }
        return false;
    }

    public function maxLength($value = null, $maximum = 5): bool
    {
        if($this->respect()->stringType()->length(null, $maximum)->validate($value)){
            return true;
        }
        return false;
    }

    public function exactLength($value = null, $compareTo = 0): bool
    {
        if($this->respect()->equals($compareTo)->validate($value)){
            return true;
        }
        return false;
    }

    public function greaterThan($value = null, $min = 0, $inclusive = true): bool
    {
        if (true === $inclusive){
            if($this->respect()->intVal()->max($min, true)->validate($value)){
                return true;
            }
        }elseif($this->respect()->intVal()->max($min)->validate($value)){
            return true;
        }
        return false;
    }

    public function lessThan($value = null, $max = 0, $inclusive = true): bool
    {
        if (true === $inclusive){
            if($this->respect()->intVal()->min($max)->validate($value)){
                return true;
            }
        }elseif($this->respect()->intVal()->min($max)->validate($value)){
            return true;
        }

        return false;
    }

    public function alpha($value = null): bool
    {
        if($this->respect()->alpha()->validate($value)){
            return true;
        }
        return false;
    }

    public function alphanumeric($value = null): bool
    {
        if($this->respect()->alnum()->validate($value)){
            return true;
        }
        return false;
    }

    public function startsWith($value = null, $match = null): bool
    {
        if($this->respect()->startsWith($value)->validate($match)){
            return true;
        }
        return false;
    }

    public function endsWith($value = null, $match = null): bool
    {
        if($this->respect()->endsWith($value)->validate($match)){
            return true;
        }
        return false;
    }

    public function contains($value = null, $match = null): bool
    {
        if($this->respect()->contains($value)->validate($match)){
            return true;
        }
        return false;
    }

    public function regex($value = null, $regex = null): bool
    {
        if($this->respect()->regex($regex)->validate($value)){
            return true;
        }
        return false;
    }

    public function isGreaterThan($value, $length = 5): bool
    {
        if($this->respect()->stringType()->length(null, $length)->validate($value)){
            return true;
        }
        return false;
    }

    public function isLessThan($value, $length = 5): bool
    {
        if($this->respect()->stringType()->length($length, null)->validate($value)){
            return true;
        }
        return false;
    }

    public function isIdentical($val1, $val2): bool
    {
        if($this->respect()->equals($val1)->validate($val2)){
            return true;
        }
        return false;
    }

    public function isInRange($value, $minimum, $maximum): bool
    {
        if($this->respect()->stringType()->length($minimum, $maximum)->validate($value)){
            return true;
        }
        return false;
    }

    public function isInteger($value): bool
    {
        if($this->respect()->intVal()->validate($value)){
            return true;
        }
        return false;
    }

    public function isNumeric($value): bool
    {
        if($this->respect()->numeric()->validate($value)){
            return true;
        }
        return false;
    }

    public function isBool($value): bool
    {
        return $this->isBoolean($value);
    }

    public function isBoolean($value): bool
    {
        if($this->respect()->boolVal()->validate($value)){
            return true;
        }elseif($this->respect()->boolType()->validate($value)){
            return true;
        }
        return false;
    }

    public function isTrue($value): bool
    {
        if($this->respect()->trueVal()->validate($value) == true){
            return true;
        }
        return false;
    }

    public function isFloat($value): bool
    {
        if (is_float($value)){
            return true;
        }
        return false;
    }

    public function isFalse($value): bool
    {
        if($this->respect()->trueVal()->validate($value) == false){
            return true;
        }
        return false;
    }

    public function isEmpty($value): bool
    {

        // if is an array or an object
        if ($this->isArrayOrObject($value)){
            if ($this->isUsableArrayObject($value)){
                return true;
            }
        }
        elseif ( empty($value) && strlen($value) == 0 ){
            return true;
        }

        return false;
    }

    /**
     * Compare string to null designation
     *
     * @param  string $str
     * @return bool
     */
    public function isNull(string $str): bool
    {
        if (!isset($str) || trim($str) === '' || ($str === '<null>') || $str === 'null') {
            return true;
        }
        return  false;
    }

    /**
     * Determine whether a variable has a non-empty value.
     *
     * Alternative to {@see empty()} that accepts non-empty values:
     * - _0_ (0 as an integer)
     * - _0.0_ (0 as a float)
     * - _"0"_ (0 as a string)
     *
     * @param  mixed $number The value to be checked.
     * @return boolean Returns true if var exists and has a non-empty value. Otherwise, returns true.
     */
    public function isBlank(mixed $number): bool
    {
        return empty($number) && !is_numeric($number);
    }

    /**
     * Check if the given string is valid base 64 encoded.
     *
     * @param string $value The value to check.
     * @return bool Return `true` if valid base 64 encoded, `false` for not.
     *@since 1.0.4
     */
    public function isBase64Encoded($value)
    {
        if (!is_string($value)) {
            // if the value to check is NOT string
            // Due to base64_decode() on PHP document site require that this argument should be string, if it is not then just return false.
            return false;
        }

        $decoded = base64_decode($value, true);
        if (false === $decoded) {
            return false;
        }

        if (false === json_encode([$decoded])) {
            return false;
        }

        return true;
    }// isBase64Encoded

    /**
     * Check if JSON encoded or valid JSON string.
     *
     * Please double check with type, otherwise it may cause unexpected result when you encode/decode it.<br>
     * Example: `$Serializer->isJSONEncoded(true);` This will return true but when you decode, it will becomes 1 (int).<br>
     * `$Serializer->isJSONEncoded('12345');` This will be also return true but when you decide, it will becomes 12345 (int).<br>
     *
     * @link https://stackoverflow.com/a/3845829/128761 Original source code.
     * @since 1.0.3
     * @param mixed $value The value to check.
     * @return boolean Return `true` if it is valid JSON, `false` for not.
     */
    public function isJSONEncoded($value)
    {
        if (!is_scalar($value)) {
            return false;
        }

        $pcre_regex = '
/
(?(DEFINE)
(?<number>   -? (?= [1-9]|0(?!\d) ) \d+ (\.\d+)? ([eE] [+-]? \d+)? )
    (?<boolean>   true | false | null )
        (?<string>    " ([^"\\\\]* | \\\\ ["\\\\bfnrt\/] | \\\\ u [0-9a-f]{4} )* " )
            (?<array>     \[  (?:  (?&json)  (?: , (?&json)  )*  )?  \s* \] )
                (?<pair>      \s* (?&string) \s* : (?&json)  )
                    (?<object>    \{  (?:  (?&pair)  (?: , (?&pair)  )*  )?  \s* \} )
                        (?<json>   \s* (?: (?&number) | (?&boolean) | (?&string) | (?&array) | (?&object) ) \s* )
                            )
                            \A (?&json) \Z
                            /six
                            ';

        $pcre_regex = trim($pcre_regex);

        if (preg_match($pcre_regex, $value) === 1) {
            return true;
        }
        return false;
    }// isJSONEncoded

    /**
     * Is serialized string.
     *
     * @link https://core.trac.wordpress.org/browser/tags/4.7.3/src/wp-includes/functions.php#L341 Reference from WordPress.
     * @link https://gist.github.com/cs278/217091 Reference from Github cs278/is_serialized.php
     * @param string $value The string to check.
     * @return boolean Return true if serialized, false for otherwise.
     */
    public function isSerialized($value)
    {
        if (!is_string($value)) {
            return false;
        }

        $value = trim($value);

        $status = function ($string){
            if ($string === 'N;') {
                // if serialized string is NULL.
                return true;
            }

            $string_encoding = mb_detect_encoding($string);
            $length = mb_strlen($string, $string_encoding);
            $last_char = mb_substr($string, -1, NULL, $string_encoding);
            unset($string_encoding);

            if ($length < 4) {
                // if total characters of this string (string length) is less than 4 then it is not serialized except NULL which is verified above.
                unset($last_char, $length);
                return false;
            }

            if ($string[1] !== ':') {
                // if character number 2 (offset 1, start at 0) from this string is not colon means it is not serialized string.
                unset($last_char, $length);
                return false;
            }

            if (in_array($string[0], ['b', 'i', 'd', 's']) && $last_char !== ';') {
                // if first character maybe boolean, integer, double or float, string but last character is not semicolon means it is not serialized string.
                unset($last_char, $length);
                return false;
            } elseif (in_array($string[0], ['a', 'O']) && $last_char !== '}') {
                // last character of array, object is not right curly bracket means it is not serialized string.
                unset($last_char, $length);
                return false;
            }

            // switch to first character of this string.
            switch ($string[0]) {
                case 'b':
                    // this maybe boolean
                    if ($length > 4 || ($string[2] !== '0' && $string[2] !== '1')) {
                        // if string length is more than 4 or character number 3 (offset 2) is not 0 (false) and is not 1 (true) means it is not serialized string.
                        return false;
                    } elseif ($length == 4 && ($string[2] === '0' || $string[2] === '1')) {
                        // if string length is exactly 4 and character number 3 (offset 2) is 0 (false) or 1 (true) means it is serialized string.
                        return true;
                    } else {
                        return false;
                    }
                case 'i':
                    // this maybe integer
                    return (boolean) preg_match('#^'.$string[0].':[0-9\-]+\\'.$last_char.'#', $string);
                case 'd':
                    // this maybe double or float
                    return (boolean) preg_match('#^'.$string[0].':[0-9\.E\-\+]+\\'.$last_char.'#', $string);
                case 's':
                    // this maybe string
                    $exp_string = explode(':', $string);
                    if (isset($exp_string[1]) && isset($exp_string[2])) {
                        // if found number of total characters in serialize, count to make sure that it is matched.
                        unset($last_char, $length);
                        // number in serialized string type seems to use `strlen` because it is not counting the real unicode characters.
                        return (intval($exp_string[1]) === intval(strlen(trim($exp_string[2], ';"'))));
                    }
                    unset($exp_string, $last_char, $length);
                    return false;
                case 'a':
                    // this maybe array
                case 'O':
                    // this maybe object
                    return (boolean) preg_match('#^'.$string[0].':[0-9]+\:#s', $string);
            }// endswitch;

            return false;
        };

        return (new Serialize)->is($value) || $status($value);

    }// isSerialized

    /**
     * Check some basic requirements of all serialized strings
     *
     * @param string $value
     * @param int $length
     * @param int $minLength
     * @return bool
     */
    protected function checkBasic(string $value, int $length, int $minLength = 4): bool
    {
        return $length < $minLength || $value[1] !== ':' || ($value[$length - 1] !== ';' && $value[$length - 1] !== '}');
    }

    public function isNumber($value): bool
    {
        return is_integer($value) || is_float($value);
    }

    public function isString($value): bool
    {

        // ensure it's of a string type value and !empty
        if( $this->respect()->StringType()->validate($value) && !(empty($value) && strlen($value) == 0  || is_null($value)))
        {
            return true;
        }

        return false;
    }

    public function isJson($value): bool
    {

        if (!is_string($value)) {
            return false;
        }

        return $this->respect()->json()->validate($value)

            // checks for calculating if the string given to it is JSON.
            // So, it is the most perfect one, but it's slower than the other.
            # Requires PHP 5.4 and above
            || !is_string($value) && is_object(json_decode($value)) && (json_last_error() == JSON_ERROR_NONE);
    }

    public function isXml($value): bool
    {
        if (!$this->isString($value)) {
            return false;
        }

        return (new Xml())->isValid($value, null, true) || (@simplexml_load_string($value) instanceof SimpleXMLElement);
    }

    /**
     * Determines if an array is associative.
     *
     * @param  array $value
     * @return bool
     */
    public function isAssocArray(array $value): bool
    {
        if (array_keys( $value ) !== range( 0, count( $value ) - 1 )){
            return true;
        }
        return false;
    }

    public function isArray($value): bool
    {
        return $this->respect()->arrayType()->validate($value) || is_array($value);
    }

    public function isObject($value): bool
    {
        return $this->respect()->objectType()->validate($value) || is_object($value) || $value instanceof stdClass;
    }

    public function isArrayOrObject($value): bool
    {

        if($this->respect()->arrayVal()->validate($value)){
            return true;
        }
        elseif($this->respect()->arrayType()->validate($value)){
            return true;
        }
        return false;
    }

    public function isUsableArrayObject($value, $filter = true): bool
    {
        if (!$this->isArrayOrObject($value)){
            return false;
        }

        // remove empty values
        $value = true === $filter ? (new PhegArr)->filter($value) : $value;

        // if array is not empty
        if ($this->respect()->arrayVal()->notEmpty()->validate($value)){
            return true;
        }
        return false;
    }

    public function inArray($value = null, array $list = []):bool
    {
        return in_array($value, $list);
    }

    public function isFoundInArray($needle, array $values): bool
    {
        $found = false;
        foreach ($values as $key => $item) {
            if ($needle === $key) {
                $found = true;
                break;
            } elseif (is_array($item)) {
                $found = $this->isFoundInArray($needle, $item);
                if($found) {
                    break;
                }
            }
        }
        return $found;
    }

    public function isInArrayKey($key, array $values): bool
    {
        return array_key_exists((string)$key, $values);
    }

    /**
     * Check is value exists in the array
     *
     * @param mixed $value
     * @param array $values
     * @param bool  $returnKey
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function isInArray($value, array $values, bool $returnKey = false)
    {
        $status = in_array($value, $values, true);

        if ($returnKey) {
            if ($status) {
                return array_search($value, $values, true);
            }

            return null;
        }

        return $status;
    }

    /**
     * @param object $values
     * @return bool
     */
    public function isEmptyObject(object $values): bool
    {
        return empty((array) $values);
    }

}
