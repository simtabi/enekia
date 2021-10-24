<?php

namespace Simtabi\Enekia\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use File;

class EnekiaServiceProvider extends ServiceProvider
{

    private const PACKAGE_NAME = 'enekia';
    private const PATH         = __DIR__ . '/../../';

    public function register()
    {
        self::autoload(self::PATH . 'helpers');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // load translation files
        $this->loadTranslationsFrom(self::PATH . 'resources/lang', 'messages');

        $this->registerPublishables();
    }

    private function registerPublishables(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::PATH.'resources/lang' => resource_path('lang/vendor/' . self::PACKAGE_NAME),
            ], self::PACKAGE_NAME .':translations');
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
