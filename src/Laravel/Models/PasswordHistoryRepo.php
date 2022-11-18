<?php

namespace Simtabi\Enekia\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordHistoryRepo
{
    /**
     * @param $password
     * @param $userId
     */
    public static function storeCurrentPasswordInHistory($password, $userId)
    {
        PasswordHistory::create(get_defined_vars());
    }

    /**
     * @param Model $user
     * @param $checkPrevious
     * @return mixed
     */
    public static function fetchUser(Model $user, $checkPrevious)
    {
        return PasswordHistory::where('user_id', $user->id)->latest()->take($checkPrevious)->get();
    }
}
