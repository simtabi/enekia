<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Database;

use Illuminate\Support\Facades\DB;

trait MustBeEqualValue
{
    /**
     * @var string
     */
    private $column;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $identifierColumn;

    /**
     * @var string
     */
    private $uniqueIdentifier;

    /**
     * @var mixed
     */
    private $foundValue;

    /**
     * @var mixed
     */
    private $postedValue;

    /**
     * @var bool
     */
    protected bool $checkMustBeEqualValue = false;

    /**
     * @return static
     */
    public function checkMustBeEqualValue(string $table, string $column, string $identifierColumn, string $uniqueIdentifier): static
    {
        $this->checkMustBeEqualValue = true;
        $this->table                 = $table;
        $this->column                = $column;

        $this->identifierColumn      = $identifierColumn;
        $this->uniqueIdentifier     = $uniqueIdentifier;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateMustBeEqualValue($attribute, $value): bool
    {
        $result = DB::table($this->table)
            ->where($this->identifierColumn, $this->uniqueIdentifier)
            ->first();

        if ($result === null) {
            return false;
        }

        $this->foundValue  = $result->{$this->column};
        $this->postedValue = $value;

        return $this->foundValue == $this->postedValue;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The found value '{$this->foundValue}' does not match '{$this->postedValue}'";
    }
}
