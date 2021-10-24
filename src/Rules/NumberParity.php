<?php

declare(strict_types=1);

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;
use Simtabi\Enekia\Exceptions\NumberParityException;
use function __;
use function filter_var;

class NumberParity extends AbstractRule implements Rule
{
    /** @var null|string */
    protected $mode = null;

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     * @throws NumberParityException
     */
    public function passes($attribute, $value): bool
    {

        $this->setAttribute($attribute);

        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return false;
        }

        if (null === $this->mode) {
            throw new NumberParityException('Ensure the "odd()" or "even()" methods are called');
        }

        return $this->mode === 'odd'
            ? (int) $value % 2 !== 0
            : (int) $value % 2 === 0;
    }

    /**
     * @return $this
     */
    public function odd(): self
    {
        $this->mode = 'odd';

        return $this;
    }

    /**
     * @return $this
     */
    public function even(): self
    {
        $this->mode = 'even';

        return $this;
    }

    /**
     * @return string
     */
    public function customMessage(): string
    {
        return __(
            'validation::messages.'.$this->shortname().'.'.$this->mode,
            [
                'attribute' => $this->getAttribute(),
            ]
        );
    }
}
