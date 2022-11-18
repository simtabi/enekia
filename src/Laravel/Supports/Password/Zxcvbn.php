<?php

namespace Simtabi\Enekia\Laravel\Validators\Password;

use InvalidArgumentException;
use stdClass;
use ZxcvbnPhp\Matchers\BaseMatch;
use ZxcvbnPhp\Zxcvbn as ZxcvbnPhp;

/**
 * Class for validating passwords using Dropbox's Zxcvbn library.
 */
class Zxcvbn
{
    const DEFAULT_MINIMUM_STRENGTH = 3;

    /** @var string */
    private string     $messageKey;

    /** @var bool */
    private bool       $verbose = false;

    public function __construct(bool $verbose = false)
    {
        $this->verbose = $verbose;
    }

    public function validate($value, int $desiredScore = self::DEFAULT_MINIMUM_STRENGTH, ?string $email = null, ?string $username = null): bool
    {

        $result = (new ZxcvbnPhp())->passwordStrength(trim($value), [$username, $email,]);

        // check score
        if (($result['score'] ?? 0) >= $this->getDesiredScore($desiredScore)) {
            return true;
        }

        $this->messageKey = 'password.strength.' . ($this->verbose ? $this->getFeedbackTranslation($result) : 'weak');

        return false;
    }

    /**
     * @return string
     */
    public function getMessageKey(): string
    {
        return $this->messageKey;
    }

    private function getDesiredScore(int $desiredScore = self::DEFAULT_MINIMUM_STRENGTH): int
    {

        if (($desiredScore < 0) || ($desiredScore > 4) || !ctype_digit($desiredScore)) {
            throw new InvalidArgumentException(trans('validation::validation.password.invalid_score'));
        }

        return $desiredScore;
    }






    private function getFeedbackTranslation(array $result)
    {
        $isOnlyMatch         = count($result['sequence']) === 1;

        $longestMatch        = new stdClass();
        $longestMatch->token = '';

        foreach ($result['sequence'] as $match) {
            if (strlen($match->token) > strlen($longestMatch->token)) {
                $longestMatch = $match;
            }
        }

        return $this->getMatchFeedback($longestMatch, $isOnlyMatch);
    }

    private function getMatchFeedback(BaseMatch $match, $isOnlyMatch)
    {
        $pattern  = mb_strtolower($match->pattern);
        $strategy = 'get' . ucfirst($pattern) . 'Warning';
        if (method_exists($this, $strategy)) {
            return $this->$strategy($match, $isOnlyMatch);
        }

        // ['digits', 'year', 'date', 'repeat', 'sequence']
        else{
            return mb_strtolower($pattern);
        }
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function getDictionaryWarning(BaseMatch $match, bool $isOnlyMatch): string
    {
        if ($match->dictionaryName === 'passwords') {
            return $this->getPasswordWarning($match, $isOnlyMatch);
        }

        elseif (in_array($match->dictionaryName, ['surnames', 'male_names', 'female_names'], true)) {
            return 'names';
        }

        elseif ($match->dictionaryName === 'user_inputs') {
            return 'reused';
        }

        else{
            return 'common';
        }
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function getRegexWarning(BaseMatch $match): string
    {
        $warning = 'year';

        if ($match->regexName === 'recent_year') {
            return 'year';
        }

        else{
            return $warning;
        }
    }

    private function getPasswordWarning(BaseMatch $match, bool $isOnlyMatch): string
    {
        if (!$isOnlyMatch) {
            return 'suggestion';
        }

        elseif ($match->l33t) {
            return 'predictable';
        }

        elseif (isset($match->reversed) && $match->reversed === true && $match->rank <= 100) {
            return 'very_common';
        }

        elseif ($match->rank <= 10) {
            return 'top_10';
        }

        elseif ($match->rank <= 100) {
            return 'top_100';
        }

        else{
            return 'common';
        }
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function getSpatialWarning(BaseMatch $match): string
    {
        if ($match->turns === 1) {
            return 'straight_spatial';
        }

        else{
            return 'spatial_with_turns';
        }
    }

}