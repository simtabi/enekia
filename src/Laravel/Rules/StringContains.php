<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;
use Simtabi\Enekia\Exceptions\StringContainsException;
use Illuminate\Support\Str;
use function __;
use function array_map;
use function collect;
use function implode;
use function sprintf;

class StringContains extends AbstractRule implements Rule
{
    /** @var array */
    protected $phrases = [];

    /** @var bool */
    protected $mustContainAllPhrases = false;

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        $this->setAttribute($attribute);

        if ($this->phrases === []) {
            throw new StringContainsException('Zero phrases have been whitelisted using the "phrases()" method');
        }

        $matched = collect($this->phrases)->reject(
            function ($phrase) use ($value) {
                return ! Str::contains($value, $phrase);
            }
        );

        if ($this->mustContainAllPhrases) {
            return Str::containsAll($value, $this->phrases);
        }

        return $matched->isNotEmpty();
    }

    /**
     * @param  array  $phrases
     * @return self
     */
    public function phrases(array $phrases): self
    {
        $this->phrases = $phrases;

        return $this;
    }

    /**
     * @return $this
     */
    public function strictly(): self
    {
        $this->mustContainAllPhrases = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function loosely(): self
    {
        $this->mustContainAllPhrases = false;

        return $this;
    }


    /**
     * @return string
     */
    public function customMessage(): string
    {
        $key = sprintf(
            'ekenia::messages.%s.%s',
            $this->shortname(),
            $this->mustContainAllPhrases ? 'strict' : 'loose'
        );

        return __(
            $key,
            [
                'attribute' => $this->getAttribute(),
                'phrases'   => implode(
                    ', ',
                    array_map(
                        function ($phrase) {
                            return '"'.$phrase.'"';
                        },
                        $this->phrases
                    )
                ),
            ]
        );
    }
}