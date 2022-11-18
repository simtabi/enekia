<?php

namespace Simtabi\Enekia\Laravel\Rules;

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Validators\Profanity\ProfanityDictionary;
use Simtabi\Enekia\Laravel\Validators\Profanity\ProfanityStrHelper;

class Profanity extends AbstractRule implements Rule
{
    /**
     * @var ProfanityDictionary
     */
    protected ProfanityDictionary $dictionary;

    /**
     * @var array
     */
    protected array $dictionaryWords = [];

    /**
     * @var array
     */
    protected array $profaneWords    = [];

    /**
     * @var bool
     */
    protected bool  $strictFiltering = false;

    /**
     * @param ProfanityDictionary $dictionary [description]
     */
    public function __construct(ProfanityDictionary $dictionary)
    {
        $this->dictionaryWords = $dictionary->getDictionary();
        $this->parameters      = func_get_args();
        $this->dictionary      = $dictionary;
    }

    public function passes($attribute, $value)
    {
        if (!is_string($value)) {
            return true;
        }

        if ($this->parameters) {
            $this->setDictionary($this->parameters);
        }

        return !$this->isProfane($value, $this->strictFiltering);
    }

    /**
     * Check profanity of text.
     *
     * @param string $text
     * @param bool $strict
     * @return bool
     */
    public function isProfane(string $text, bool $strict = false): bool
    {
        return ProfanityStrHelper::containsCaseless(ProfanityStrHelper::removeAccent(strip_tags($text)), $this->dictionaryWords, $strict);
    }

    private function setDictionary($dictionaries)
    {
        $this->dictionary->setDictionary($dictionaries);
        $this->dictionaryWords = $this->dictionary->getDictionary();
    }

    public function setProfaneWords(array $profaneWords): static
    {
        $this->profaneWords = $profaneWords;

        return $this;
    }

    public function validateStrictly(bool $status = true): static
    {
        $this->strictFiltering = $status;

        return $this;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return 'profanity';
    }
}