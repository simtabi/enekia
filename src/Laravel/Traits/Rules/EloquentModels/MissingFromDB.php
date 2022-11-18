<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

trait MissingFromDB
{

    protected bool   $checkIfIsMissingFromDB = false;
    protected array  $table;

    public function checkIfIsMissingFromDB(string $column, string $table): static
    {
        $this->checkIfIsMissingFromDB = true;
        $this->table                  = [$table, $column,];

        return $this;
    }
    
    /**
     * Determine if the validation rule passes.
     *
     * The rule requires two parameters:
     * 1. The database table to use.
     * 2. The column on the table to compare the value against.
     *
     **/
    public function validateMissingFromDB($attribute, $value) : bool
    {
        return DB::table($this->table[0])->where($this->table[1], $value)->doesntExist();
    }

}
