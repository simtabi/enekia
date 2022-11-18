<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Providers\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use function config;
use function implode;
use function trans;

class Base64ValidationServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Validator::extend('base64max', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64Max');

        Validator::extend('base64min', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64Min');

        Validator::extend('base64dimensions', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64Dimensions');

        Validator::extend('base64file', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64File');

        Validator::extend('base64image', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64Image');

        Validator::extend('base64mimetypes', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64Mimetypes');

        Validator::extend('base64mimes', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64Mimes');

        Validator::extend('base64between', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64Between');

        Validator::extend('base64size', 'Simtabi\Enekia\Supports\Base64Validator@validateBase64Size');

        if (config('enekia.base64.replace_validation_messages')) {
            Validator::replacer('base64max', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.max.file', ['attribute' => $validator->getDisplayableAttribute($attribute), 'max' => $parameters[0]]);
            });

            Validator::replacer('base64min', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.min.file', ['attribute' => $validator->getDisplayableAttribute($attribute), 'min' => $parameters[0]]);
            });

            Validator::replacer('base64dimensions', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.dimensions', ['attribute' => $validator->getDisplayableAttribute($attribute)]);
            });

            Validator::replacer('base64file', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.file', ['attribute' => $validator->getDisplayableAttribute($attribute)]);
            });

            Validator::replacer('base64image', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.image', ['attribute' => $validator->getDisplayableAttribute($attribute)]);
            });

            Validator::replacer('base64mimetypes', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.mimetypes', [
                    'attribute' => $validator->getDisplayableAttribute($attribute),
                    'values'    => implode(',', $parameters)
                ]);
            });

            Validator::replacer('base64mimes', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.mimes', [
                    'attribute' => $validator->getDisplayableAttribute($attribute),
                    'values'    => implode(',', $parameters),
                ]);
            });

            Validator::replacer('base64between', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.between.file', [
                    'attribute' => $validator->getDisplayableAttribute($attribute),
                    'min'       => $parameters[0],
                    'max'       => $parameters[1]
                ]);
            });

            Validator::replacer('base64size', function ($message, $attribute, $rule, $parameters, $validator) {
                return trans('validation.size.file', [
                    'attribute' => $validator->getDisplayableAttribute($attribute),
                    'size'      => $parameters[0],
                ]);
            });
        }

    }

    /**
     * @return void
     */
    public function register(): void
    {

    }
}