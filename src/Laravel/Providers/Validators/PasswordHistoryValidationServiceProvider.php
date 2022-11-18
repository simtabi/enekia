<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Providers\Validators;

use Illuminate\Support\ServiceProvider;
use Simtabi\Enekia\Laravel\Console\ClearOldPasswordHistory;
use Simtabi\Enekia\Laravel\Observers\PasswordHistoryUserObserver;

class PasswordHistoryValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole())
        {
            $this->commands([
                ClearOldPasswordHistory::class,
            ]);
        }

        if ($this->app->runningInConsole())
        {
            //Registering package commands.
            $this->commands([
                ClearOldPasswordHistory::class,
            ]);
        }

        $model = config('enekia.password_history.observer.model');

        if (class_exists($model))
        {
            $model::observe(PasswordHistoryUserObserver::class);
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
