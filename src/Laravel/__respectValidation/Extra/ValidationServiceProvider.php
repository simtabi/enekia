<?php declare(strict_types=1);

namespace Simtabi\Laranail\Providers\Extra;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as lv;
use Simtabi\Laranail\Helpers\Validator;

final class ValidationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app['validator']->resolver(static function ($translator, $data, $rules, $messages, $customAttributes) {
            return new Validator($translator, $data, $rules, $messages, $customAttributes);
        });

        lv::extend('uuid', function ($attribute, $value, $parameters, $validator) {
            return PhegUuid::validate($value);
        });

    }


}