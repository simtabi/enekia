<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Simtabi\Enekia\Laravel\Providers\Validators\Base64ValidationServiceProvider;
use Simtabi\Enekia\Laravel\Providers\Validators\PasswordHistoryValidationServiceProvider;
use Simtabi\Enekia\Laravel\Providers\Validators\UrlValidationServiceProvider;
use Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\DisposableServiceProvider;
use Simtabi\Enekia\Validator;

class EnekiaServiceProvider extends ServiceProvider
{

    private string $packageName = 'enekia';
    private const  PACKAGE_PATH = __DIR__ . '/../../../';

    public function register()
    {
        $this->loadTranslationsFrom(self::PACKAGE_PATH . "resources/lang/", $this->packageName);
        $this->loadViewsFrom(self::PACKAGE_PATH        . "resources/views", $this->packageName);
        $this->mergeConfigFrom(self::PACKAGE_PATH      . "config/config.php", $this->packageName);

        self::autoload(self::PACKAGE_PATH . 'helpers');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // add rules to laravel validator
        foreach (Validator::getRuleShortnames() as $ruleName) {
            $this->app['validator']->extend($ruleName, function ($attribute, $value, $parameters, $validator) use ($ruleName) {
                return forward_static_call([Validator::class, 'is' . ucfirst($ruleName)], $value, data_get($parameters, 0));
            }, $this->getErrorMessage($ruleName));
        }

        $this->registerConsoles();

        $this->app->booted(function () {
            $this->app->register(Base64ValidationServiceProvider::class);
            $this->app->register(DisposableServiceProvider::class);
            $this->app->register(PasswordHistoryValidationServiceProvider::class);
            $this->app->register(UrlValidationServiceProvider::class);
        });
    }

    /**
     * Return error message of given rule shortname
     *
     * @param  string $ruleName
     * @return string
     */
    protected function getErrorMessage(string $ruleName): string
    {
        return $this->app['translator']->get('validation::validation.' . $ruleName);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['validator'];
    }

    private function registerConsoles(): static
    {
        if ($this->app->runningInConsole())
        {

            $this->publishes([
                self::PACKAGE_PATH . "config/config.php"               => config_path("{$this->packageName}.php"),
            ], "{$this->packageName}:config");

            $this->publishes([
                self::PACKAGE_PATH . "public"                          => public_path("vendor/{$this->packageName}"),
            ], "{$this->packageName}:assets");

            $this->publishes([
                self::PACKAGE_PATH . "resources/views"                 => resource_path("views/vendor/{$this->packageName}"),
            ], "{$this->packageName}:views");

            $this->publishes([
                self::PACKAGE_PATH . "resources/lang"                 => $this->app->useLangPath("vendor/{$this->packageName}"),
            ], "{$this->packageName}:translations");
        }

        return $this;
    }

    private static function autoload(string $directory): void
    {
        $helpers = File::glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }

}
