# Laravel Email Domain Rule

This is the content of the published config file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Email Domain model
    |--------------------------------------------------------------------------
    |
    | Here you may specify the fully qualified class name of the email domain model.
    |
    */

    'model' => Simtabi\Enekia\Laravel\Models\EmailDomain::class,

    /*
    |--------------------------------------------------------------------------
    | Email Domain wildcard
    |--------------------------------------------------------------------------
    |
    | Here you may specify the character used as wildcard for all email domains.
    |
    */

    'wildcard' => '*',
];
```

## Usage

### Basic

To use the package, run the migration and fill in the table with a list of accepted email domains for your application.

You can then just add the custom validation rule to validate, for example, a user registration form.

```php
use Simtabi\Enekia\Laravel\Traits\Rules\Email;
use Illuminate\Support\Facades\Validator;

$email = 'my-email@example.com';

Validator::make([
    'email' => $email,
], [
    'email' => [
        'string',
        'email',
        (new Email)->checkEmailDomain(),
    ],
])->validated(); 
```

That's all!
Laravel will handle the rest by validating the input and throwing an error message if validation fails.

### Wildcard domains

If needed, you can optionally add wildcard domains to the `email_domains` database table: the custom rule will handle the rest.

The default wildcard character is an asterisk (`*`), but you can customize it within the `wildcard` setting.

```php
use Simtabi\Enekia\Laravel\Traits\Rules\Email;
use Simtabi\Enekia\Laravel\Models\EmailDomain;
use Illuminate\Support\Facades\Validator;

EmailDomain::create(['domain' => '*.example.com']);

Validator::make([
    'email' => 'info@example.com',
], [
    'email' => ['string', 'email', (new Email)->checkEmailDomain()],
])->fails(); // returns true as the given domain is not in the list

Validator::make([
    'email' => 'info@subdomain.example.com',
], [
    'email' => ['string', 'email', (new Email)->checkEmailDomain()],
])->fails(); // returns false as the given domain matches the wildcard domain
```

### Model customization

You can also override the default `EmailDomain` model to add any additional field by changing the `model` setting.

This can be useful when working with a multi-tenancy scenario in a single database system: in this case you can just add a `tenant_id` column to the migration and model classes, and apply a global scope to the custom model.

```php
use Simtabi\Enekia\Laravel\Traits\Rules\Email as BaseEmailDomain;
use Illuminate\Database\Eloquent\Builder;

class EmailDomain extends BaseEmailDomain
{
    protected $fillable = [
        'domain',
        'tenant_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope('tenantAware', function (Builder $builder) {
            $builder->where('tenant_id', auth()->user()->tenant_id);
        });
    }
}
```













Validation rule for Laravel 5.5 to validate that a given email
address belongs to the provided domain.

Wildcard domains and multiple domains are supported.

## Basic Usage

If your class implements the Laravel `ValidatesRequests` trait
you can validate a simple domain as follows.

```php
use Simtabi\Enekia\Laravel\Rules\Email;

$this->validate(request()->all(), [
    'email' => ['email', (new Email())->checkEmailDomain('example.com')]
])
```

This validation rule will only pass if the email provided
is `@example.com`.

## Wildcard Usage

```php
use Simtabi\Enekia\Laravel\Rules\Email;

$this->validate(request()->all(), [
    'email' => ['email', (new Email())->checkEmailDomain('*.example.com')]
])
```

This rule wil match any of `mail.example.com`,
`test.example.com`, etc. To match `mail.test.example.com` the
rule must be `new EmailDomain('*.*.example.com')`.

## Match Multiple Domains

To match multiple domains simply pass an array of accepted
domains to the constructor. You can pass any number of domains
and wildcards as an array to check them all.

```php
use Simtabi\Enekia\Laravel\Rules\Email;

$this->validate(request()->all(), [
    'email' => ['email', (new Email())->checkEmailDomain(['example.org', 'example.com'])]
])
```

## Strict Mode

Strict mode can be disabled to match wildcard domains. This is
useful if you would like to match all subdomains under
`example.com`.

The following example will match `example.com` domains and
any length of subdomains under it.

```php
use Simtabi\Enekia\Laravel\Rules\Email;

$domainRule = ;
$this->validate(request()->all(), [
    'email' => ['email', (new Email())->checkEmailDomain(['example.com', ['*.example.com']], false)]
])
```