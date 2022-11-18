<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber;

use Illuminate\Support\ServiceProvider;
use Simtabi\Enekia\Laravel\Validators\Respect\RespectValidationRuleFactory;

class RespectValidationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app['validator']->resolver(static function ($translator, $data, $rules, $messages, $customAttributes) {
            return new RespectValidationRuleFactory($translator, $data, $rules, $messages, $customAttributes);
        });
    }
}