<?php

namespace Simtabi\Enekia\Laravel\Providers;

use File;
use Illuminate\Validation\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class EnekiaServiceProvider extends ServiceProvider
{

    private string $packageName = 'enekia';
    private const  PACKAGE_PATH = __DIR__ . '/../../../';

    public function register()
    {
        $this->loadTranslationsFrom(self::PACKAGE_PATH . "resources/lang/", $this->packageName);
        $this->loadMigrationsFrom(self::PACKAGE_PATH.'/../database/migrations');
        $this->loadViewsFrom(self::PACKAGE_PATH . "resources/views", $this->packageName);
        $this->mergeConfigFrom(self::PACKAGE_PATH . "config/{$this->packageName}.php", $this->packageName);

        self::autoload(self::PACKAGE_PATH . 'helpers');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConsoles();
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

    private static function autoload(string $directory): void
    {
        $helpers = File::glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }


    private function registerConsoles(): static
    {
        if ($this->app->runningInConsole())
        {

            $this->publishes([
                self::PACKAGE_PATH . "config/{$this->packageName}.php" => config_path("{$this->packageName}.php"),
            ], "{$this->packageName}:config");

            $this->publishes([
                self::PACKAGE_PATH . "public"                          => public_path("vendor/{$this->packageName}"),
            ], "{$this->packageName}:assets");

            $this->publishes([
                self::PACKAGE_PATH . "resources/views"                 => resource_path("views/vendor/{$this->packageName}"),
            ], "{$this->packageName}:views");

            $this->publishes([
                self::PACKAGE_PATH . "resources/lang"                 => $this->app->langPath("vendor/{$this->packageName}"),
            ], "{$this->packageName}:translations");
        }

        return $this;
    }

}
