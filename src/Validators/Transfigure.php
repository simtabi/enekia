<?php

namespace Simtabi\Enekia\Validators;

use DOMDocument;
use SimpleXMLElement;
use Simtabi\Enekia\Validators\Traits\WithRespectValidationTrait;
use Simtabi\Pheg\Toolbox\Serialize;

class Transfigure
{

    use WithRespectValidationTrait;

    private function __construct(){}

    public static function invoke(): self
    {
        return new self();
    }

    /**
     * Check if the given string is valid base 64 encoded.
     *
     * @since 1.0.4
     * @param string $data The value to check.
     * @return bool Return `true` if valid base 64 encoded, `false` for not.
     */
    public function isBase64Encoded($data)
    {
        if (!is_string($data)) {
            // if the value to check is NOT string
            // Due to base64_decode() on PHP document site require that this argument should be string, if it is not then just return false.
            return false;
        }

        $decoded = base64_decode($data, true);
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
     * @param mixed $data The value to check.
     * @return boolean Return `true` if it is valid JSON, `false` for not.
     */
    public function isJSONEncoded($data)
    {
        if (!is_scalar($data)) {
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

        if (preg_match($pcre_regex, $data) === 1) {
            return true;
        }
        return false;
    }// isJSONEncoded

    /**
     * Is serialized string.
     *
     * @link https://core.trac.wordpress.org/browser/tags/4.7.3/src/wp-includes/functions.php#L341 Reference from WordPress.
     * @link https://gist.github.com/cs278/217091 Reference from Github cs278/is_serialized.php
     * @param string $string The string to check.
     * @return boolean Return true if serialized, false for otherwise.
     */
    public function isSerialized($string)
    {
        if (!is_string($string)) {
            return false;
        }

        $string = trim($string);

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

        return Serialize::invoke()->is($string) || $status($string);

    }// isSerialized

    /**
     * Check some basic requirements of all serialized strings
     *
     * @param string $data
     * @param int $length
     * @param int $minLength
     * @return bool
     */
    protected function checkBasic(string $data, int $length, int $minLength = 4): bool
    {
        return $length < $minLength || $data[1] !== ':' || ($data[$length - 1] !== ';' && $data[$length - 1] !== '}');
    }

    public function isNumber($data): bool
    {
        return is_integer($data) || is_float($data);
    }

    public function isArray($data): bool
    {
        return is_array($data) && (empty($data) || array_keys($data) === range(0, count($data) - 1));
    }

    public function isObject($data): bool
    {
        return is_object($data) || (is_array($data) && !empty($data) && array_keys($data) !== range(0, count($data) - 1));
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

    public function isXml($resource): bool
    {
        return Xml::invoke()->isValid($resource, null, true) || (@simplexml_load_string($resource) instanceof SimpleXMLElement);
    }

    public function isString($resource): bool
    {
        return is_string($resource);
    }

}