<?php

namespace Simtabi\Enekia\Laravel\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Simtabi\Enekia\Laravel\Models\PasswordHistory;

trait HasPasswordHistory
{

    /**
     * @return mixed
     */
    public function passwordHistory(): HasMany
    {
        return $this->hasMany(PasswordHistory::class)->latest();
    }

    public function deletePasswordHistory()
    {
        $keep = config('enekia.password_history.max_count');
        $ids  = $this->passwordHistory()->pluck('id')->sort()->reverse();

        if (!($ids->count() < $keep)) {

            $delete = $ids->splice($keep);

            return $this->passwordHistory()->whereIn('id', $delete)->delete();
        }

        return false;
    }

}
