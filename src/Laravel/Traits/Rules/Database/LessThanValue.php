<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Database;

use Illuminate\Support\Facades\DB;

trait LessThanValue
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
    protected bool $checkLessThanValue = false;

    public function checkLessThanValue(string $table, string $column, string $identifierColumn, string $uniqueIdentifier): static
    {
        $this->checkLessThanValue = true;
        $this->table              = $table;
        $this->column             = $column;

        $this->identifierColumn   = $identifierColumn;
        $this->uniqueIdentifier   = $uniqueIdentifier;

        return $this;
    }

    public function validateLessThanValue($attribute, $value): bool
    {
        $res = DB::table($this->table)
            ->where($this->identifierColumn, $this->uniqueIdentifier)
            ->first();

        if ($res === null) {
            return false;
        }

        $this->foundValue = $res->{$this->column};

        return $value < $this->foundValue;
    }

}
