<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Database;

use Illuminate\Support\Facades\DB;

trait MoreThanOrEqualValue
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
    protected bool $checkMoreThanOrEqualValue = false;

    /**
     * @param string $table
     * @param string $column
     * @param string $identifierColumn
     * @param string $uniqueIdentifier
     * @return static
     */
    public function checkMoreThanOrEqualValue(string $table, string $column, string $identifierColumn, string $uniqueIdentifier): static
    {
        $this->checkMoreThanOrEqualValue    = true;
        $this->table            = $table;
        $this->column           = $column;

        $this->identifierColumn = $identifierColumn;
        $this->uniqueIdentifier = $uniqueIdentifier;

        return $this;
    }

    public function validateMoreThanOrEqualValue($attribute, $value): bool
    {
        $res = DB::table($this->table)
            ->where($this->identifierColumn, $this->uniqueIdentifier)
            ->first();

        if ($res === null) {
            return false;
        }

        $this->foundValue = $res->{$this->column};

        return $value >= $this->foundValue;
    }

}
