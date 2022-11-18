<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Database;

use Illuminate\Support\Facades\DB;

trait MoreThanValue
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
     * @var bool
     */
    protected bool $checkMoreThanValue = false;

    /**
     * @param string $table
     * @param string $column
     * @param string $identifierColumn
     * @param string $uniqueIdentifier
     * @return static
     */
    public function checkMoreThanValue(string $table, string $column, string $identifierColumn, string $uniqueIdentifier): static
    {
        $this->checkMoreThanValue = true;
        $this->table              = $table;
        $this->column             = $column;

        $this->identifierColumn   = $identifierColumn;
        $this->uniqueIdentifier   = $uniqueIdentifier;

        return $this;
    }

    public function validateMoreThanValue($attribute, $value): bool
    {
        $result = DB::table($this->table)
            ->where($this->identifierColumn, $this->uniqueIdentifier)
            ->first();

        if ($result === null) {
            return false;
        }

        $this->foundValue = $result->{$this->column};

        return $value > $this->foundValue;
    }

}
