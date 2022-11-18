<?php

namespace Simtabi\Enekia\Laravel\Observers;

use Illuminate\Support\Arr;
use Simtabi\Enekia\Laravel\Models\PasswordHistoryRepo;

class PasswordHistoryUserObserver
{
    public function updated($user)
    {
        $configPasswordColumn = config('enekia.password_history.observer.column');
        $password             = Arr::get($user->getChanges(), $configPasswordColumn);

        if ($password)
        {
            PasswordHistoryRepo::storeCurrentPasswordInHistory($password, $user->id);
        }
    }

    public function created($user)
    {
        $password = config('enekia.password_history.observer.column') ?? 'password';

        PasswordHistoryRepo::storeCurrentPasswordInHistory($user->{$password}, $user->id);
    }
}
