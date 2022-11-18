<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Providers\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Simtabi\Enekia\Laravel\Traits\Rules\Url;

class UrlValidationServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot() {
        Validator::extend( 'secure_url', function ( $attribute, $value, $parameters, $validator ) {
            return ( new Url() )->validateSecureUrl()->passes( $attribute, $value );
        } );

        Validator::extend( 'image_url', function ( $attribute, $value, $parameters, $validator ) {
            return ( new Url() )->validateImageUrl()->passes( $attribute, $value );
        } );
    }
}