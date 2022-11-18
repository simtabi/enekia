# Laravel Remote Rule

Easily validate data attributes through a remote request.

This package allows you to define a subset of custom rules to validate an incoming request data through an api call to a remote service.

An example usage could be an application with an open registration form which should only allow a list of emails given by a remote service.
You can find an example in the [Usage](#usage) section.


This is the content of the published config file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Config model
    |--------------------------------------------------------------------------
    |
    | Here you may specify the fully qualified class name of the config model.
    |
    */

    'config_model' => Simtabi\Enekia\Laravel\Models\RemoteRuleConfig::class,

    /*
    |--------------------------------------------------------------------------
    | Attribute cast
    |--------------------------------------------------------------------------
    |
    | Here you may specify the cast type for all model attributes who contain
    | sensitive data.
    | All attributes listed below will be encrypted by default when creating or
    | updating a model instance. You can disable this behaviour by removing
    | the attribute cast from the array.
    |
    */

    'attribute_cast' => [
        'url'     => 'encrypted',
        'method'  => 'encrypted',
        'headers' => 'encrypted:array',
        'json'    => 'encrypted:array',
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug mode
    |--------------------------------------------------------------------------
    |
    | Here you may enable or disable the debug mode. If enabled, the rule will
    | throw an exception instead of validating the attribute.
    |
    */

    'debug' => false,
];
```

## Usage

### Basic

To use the package you can create a class which extends the `RemoteRule` abstract class.

```php
use Simtabi\Enekia\Laravel\Traits\Rules\RemoteRule;

class EmailRule extends RemoteRule
{
    //
}
```

You can then create a new `RemoteRuleConfig` instance with the snake case name of the class you just created.
The model will contain the url of the remote service used to send the request along with the request method (usually `POST` or `GET`) and, if needed, the custom headers, json body and timeout.

We add this data to a database table as we consider it sensitive information, and we want to avoid hard-coding it to the codebase.
All entries of the `remote_rule_configs` database table are indeed encrypted by default (can be disabled in the configs).

You can create a remote rule config in your console with tinker:

```bash
php artisan tinker
```

```php
\Simtabi\Enekia\Laravel\Models\RemoteRuleConfig::query()->create([
    'name'    => 'email_rule',
    'url'     => 'test.example.com',
    'method'  => 'POST',
    'headers' => [], // can be null if no custom headers are required
    'json'    => [], // can be null if no custom json body is required
    'timeout' => 10, // can be null if you want to use the default timeout
]);
```

That's all! You can now just add your new custom rule to the validation array:

```php
use Illuminate\Support\Facades\Validator;

$email = 'my-email@example.com';

Validator::make([
    'email' => $email,
], [
    'email' => [
        'string',
        'email',
        new EmailRule,
    ],
])->validated(); 
```

Under the hood, the validation rule will send a request to the given url with the custom headers and body (where we append the attribute name and its value) and check whether the response is successful or not.

### Custom response status code

You can change the expected response status code by overriding the `isSuccessful` method in your custom rule.

```php
use Simtabi\Enekia\Laravel\Traits\Rules\RemoteRule;
use Illuminate\Http\Client\Response;

class EmailRule extends RemoteRule
{
    protected function isSuccessful(Response $response): bool
    {
        return $response->status() === 204;
    }
}
```

### Custom body attribute

By default, all custom rules will append the attribute key-value pair to the request body, where the key is the name of the validated attribute, and the value is the input value of the form.

You can change the body attribute sent to the remote service by overriding the `getBodyAttribute` method in your custom rule.

```php
use Simtabi\Enekia\Laravel\Traits\Rules\RemoteRule;

class EmailRule extends RemoteRule
{
    protected function getBodyAttribute(): array
    {
        return ['custom_attribute' => $this->value];
    }
}
```
