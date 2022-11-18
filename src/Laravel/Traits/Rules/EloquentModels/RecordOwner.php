<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait RecordOwner
{

    protected bool       $checkIfIsRecordOwner = false;
    protected array      $table;
    protected Auth|Model $user;

    public function checkIfIsRecordOwner(string $column, string $table, Auth|Model|null $user): static
    {
        $this->checkIfIsRecordOwner = true;
        $this->table                = [$table, $column,];
        $this->user                 = !empty($user) ? $user : Auth::id();

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
    public function validateRecordOwner($attribute, $value) : bool
    {
        return DB::table($this->table[0])->where($this->table[1], $value)->where('user_id', $this->user->id)->exists();
    }

}
