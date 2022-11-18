<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Providers\Validators;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Console\UpdateDisposableDomains;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\DisposableDomain;
use Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\Console\UpdateDisposablePhoneNumber;

class DisposableServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(UpdateDisposablePhoneNumber::class);
            $this->commands(UpdateDisposableDomains::class);
        }

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('enekia:update:disposable-phone-numbers')->weekly()->timezone(config('app.timezone'))->appendOutputTo($this->logPath());
            $schedule->command('enekia:update:disposable-domains')->weekly()->timezone(config('app.timezone'))->appendOutputTo($this->logPath());
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDisposableDomains()->registerDisposablePhoneNumber();
    }

    private function registerDisposableDomains(): static
    {
        $this->app->singleton('DisposableDomain', function ($app) {
            // Only build and pass the requested cache store if caching is enabled.
            if ($app['config']['enekia.disposable.domain.cache.enabled']) {
                $store = $app['config']['enekia.disposable.domain.cache.store'];
                $cache = $app['cache']->store($store == 'default' ? $app['config']['cache.default'] : $store);
            }

            $instance = new DisposableDomain($cache ?? null);

            $instance->setStoragePath($app['config']['enekia.disposable.domain.storage']);
            $instance->setCacheKey($app['config']['enekia.disposable.domain.cache.key']);

            return $instance->bootstrap();
        });

        $this->app->alias('DisposableDomain', DisposableDomain::class);

        return $this;
    }

    private function registerDisposablePhoneNumber(): static
    {
        $this->app->singleton('DisposablePhoneNumber', function ($app) {
            // Only build and pass the requested cache store if caching is enabled.
            if ($app['config']['enekia.disposable.phone.cache.enabled']) {
                $store = $app['config']['enekia.disposable.phone.cache.store'];
                $cache = $app['cache']->store($store == 'default' ? $app['config']['cache.default'] : $store);
            }

            $instance = new DisposablePhoneNumber($cache ?? null);

            $instance->setStoragePath($app['config']['enekia.disposable.phone.storage']);
            $instance->setCacheKey($app['config']['enekia.disposable.phone.cache.key']);

            return $instance->bootstrap();
        });

        $this->app->alias('DisposablePhoneNumber', DisposablePhoneNumber::class);

        return $this;
    }

    private function logPath(): string
    {
        return storage_path('logs/disposable.log');
    }
}