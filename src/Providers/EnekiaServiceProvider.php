<?php

namespace Simtabi\Enekia\Providers;

use File;
use Illuminate\Validation\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class EnekiaServiceProvider extends ServiceProvider
{

    private const PACKAGE_NAME    = 'enekia';
    private const PACKAGE_PATH    = __DIR__ . '/../../';

    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(self::PACKAGE_PATH . 'config/config.php', 'enekia');

        self::autoload(self::PACKAGE_PATH . 'helpers');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // load translation files
        $this->loadTranslationsFrom(self::PACKAGE_PATH . 'resources/lang', 'enekia');

        $this->registerPublishables();
    }

    private function registerPublishables(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::PACKAGE_PATH.'resources/lang' => resource_path('lang/vendor/' . self::PACKAGE_NAME),
            ], self::PACKAGE_NAME .':translations');

            $this->publishes([
                self::PACKAGE_PATH . 'config/enekia.php' => config_path('enekia.php'),
            ], self::PACKAGE_NAME .':config');
        }
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

}
