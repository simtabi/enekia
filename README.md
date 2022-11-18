<p align="center">
    <a href="https://github.com/simtabi" target="_blank">
        <img src="https://avatars1.githubusercontent.com/u/47185924" height="100px">
    </a>
    <h1 align="center">Enekia: Laravel Validation Rules</h1>
    <br>
</p>

# Intervention Validation

Intervention Validation is an extension library for Laravel's own validation system. The package adds rules to validate data like IBAN, BIC, ISBN, creditcard numbers and more.

[![Latest Version](https://img.shields.io/packagist/v/intervention/validation.svg)](https://packagist.org/packages/intervention/validation)
![build](https://github.com/Intervention/validation/workflows/build/badge.svg)
[![Monthly Downloads](https://img.shields.io/packagist/dm/intervention/validation.svg)](https://packagist.org/packages/intervention/validation/stats)

## Installation

You can install this package quick and easy with Composer.

Require the package via Composer:

    $ composer require intervention/validation

## Laravel integration

The Validation library is built to work with the Laravel Framework (>=7). It comes with a service provider, which will be discovered automatically and registers the validation rules into your installation. The package provides 30 additional validation rules including error messages, which can be used like Laravel's own validation rules.

```php
use Illuminate\Support\Facades\Validator;
use Simtabi\Enekia\Laravel\Traits\Rules\CreditCard;
use Simtabi\Enekia\Laravel\Traits\Rules\HexColor;
use Simtabi\Enekia\Laravel\Traits\Rules\Username;

$validator = Validator::make($request->all(), [
    'color' => new HexColor(3), // pass rule as object
    'number' => ['required', 'creditcard'], // or pass rule as string
    'name' => 'required|min:3|max:20|username', // combining rules works as well
]);
```

### Changing the error messages:

Add the corresponding key to `/resources/lang/<language>/validation.php` like this:

```php
// example
'iban' => 'Please enter IBAN number!',
```
Or add your custom messages directly to the validator like [described in the docs](https://laravel.com/docs/8.x/validation#manual-customizing-the-error-messages).

## Standalone usage

It is also possible to use this library without the Laravel framework. You won't have the Laravel facades available, so make sure to use `Simtabi\Enekia\Validator` for your calls.

```php
use Simtabi\Enekia\Validator;
use Simtabi\Enekia\Laravel\Traits\Rules\CreditCard;
use Simtabi\Enekia\Laravel\Exceptions\EnekiaException;

// use static factory method to create laravel validator
$validator = Validator::make($request->all(), [
    'ccnumber' => new CreditCard(),
    'iban' => ['required', 'iban'],
    'color' => 'required|hexcolor:3',
]);

// validate single values by calling static methods
$result = Validator::isHexcolor('foobar'); // false
$result = Validator::isHexcolor('#ccc'); // true
$result = Validator::isBic('foo'); // false

// assert single values
try {
    Validator::assertHexcolor('foobar');
} catch (EnekiaException $e) {
    $message = $e->getMessage();
}
```

# Available Rules

The following validation rules are available with this package.

## Base64 encoded string

The field under validation must be [Base64 encoded](https://en.wikipedia.org/wiki/Base64).

    public Simtabi\Enekia\Laravel\Traits\Rules\Base64::__construct()

## Business Identifier Code (BIC)

Checks for a valid [Business Identifier Code](https://en.wikipedia.org/wiki/ISO_9362) (BIC).

    public Simtabi\Enekia\Laravel\Traits\Rules\Bic::__construct()

## Camel case string

The field under validation must be a formated in [Camel case](https://en.wikipedia.org/wiki/Camel_case).

    public Simtabi\Enekia\Laravel\Traits\Rules\Camelcase::__construct()

## Classless Inter-Domain Routing (CIDR) 

Check if the value is a [Classless Inter-Domain Routing](https://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing) notation (CIDR).

    public Simtabi\Enekia\Laravel\Traits\Rules\Cidr::__construct()

## Creditcard Number 

The field under validation must be a valid [creditcard number](https://en.wikipedia.org/wiki/Payment_card_number).

    public Simtabi\Enekia\Laravel\Traits\Rules\Creditcard::__construct()

## Data URI scheme

The field under validation must be a valid [Data URI](https://en.wikipedia.org/wiki/Data_URI_scheme).

    public Simtabi\Enekia\Laravel\Traits\Rules\DataUri::__construct()

## Domain name 

The field under validation must be a well formed [domainname](https://en.wikipedia.org/wiki/Domain_name).

    public Simtabi\Enekia\Laravel\Traits\Rules\Domainname::__construct()

## European Article Number (EAN)

Checks for a valid [European Article Number](https://en.wikipedia.org/wiki/International_Article_Number).

    public Simtabi\Enekia\Laravel\Traits\Rules\Ean::__construct(?int $length = null)

#### Parameters

**length**

Optional integer length (8 or 13) to check only for EAN-8 or EAN-13.

## Global Trade Item Number (GTIN)

Checks for a valid [Global Trade Item Number](https://en.wikipedia.org/wiki/Global_Trade_Item_Number).

    public Simtabi\Enekia\Laravel\Traits\Rules\Gtin::__construct(?int $length = null)

#### Parameters

**length**

Optional integer length to check only for certain types (GTIN-8, GTIN-12, GTIN-13 or GTIN-14).

## Hexadecimal color code

The field under validation must be a valid [hexadecimal color code](https://en.wikipedia.org/wiki/Web_colors). 

    public Simtabi\Enekia\Laravel\Traits\Rules\HexColor::__construct(?int $length = null)

#### Parameters

**length**

Optional length as integer to check only for shorthand (3 characters) or full hexadecimal (6 characters) form.

## Text without HTML

The field under validation must be free of any html code.

    public Simtabi\Enekia\Laravel\Traits\Rules\HtmlClean::__construct()

## International Bank Account Number (IBAN)

Checks for a valid [International Bank Account Number](https://en.wikipedia.org/wiki/International_Bank_Account_Number) (IBAN).

    public Simtabi\Enekia\Laravel\Traits\Rules\Iban::__construct()

## International Mobile Equipment Identity (IMEI) 

The field under validation must be a [International Mobile Equipment Identity](https://en.wikipedia.org/wiki/International_Mobile_Equipment_Identity) (IMEI).

    public Simtabi\Enekia\Laravel\Traits\Rules\Imei::__construct()

## International Standard Book Number (ISBN)

The field under validation must be a valid [International Standard Book Number](https://en.wikipedia.org/wiki/International_Standard_Book_Number) (ISBN).

    public Simtabi\Enekia\Laravel\Traits\Rules\Isbn::__construct(?int $length = null)

#### Parameters

**length**

Optional length parameter as integer to check only for ISBN-10 or ISBN-13.

## International Securities Identification Number (ISIN) 

Checks for a valid [International Securities Identification Number](https://en.wikipedia.org/wiki/International_Securities_Identification_Number) (ISIN).

    public Simtabi\Enekia\Laravel\Traits\Rules\Isin::__construct()

## International Standard Serial Number (ISSN)

Checks for a valid [International Standard Serial Number](https://en.wikipedia.org/wiki/International_Standard_Serial_Number) (ISSN).

    public Simtabi\Enekia\Laravel\Traits\Rules\Issn::__construct()

## JSON Web Token (JWT)

The given value must be a in format of a [JSON Web Token](https://en.wikipedia.org/wiki/JSON_Web_Token).

    public Simtabi\Enekia\Laravel\Traits\Rules\Jwt::__construct()

## Kebab case string

The given value must be formated in [Kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles).

    public Simtabi\Enekia\Laravel\Traits\Rules\Kebabcase::__construct()

## Lower case string 

The given value must be all lower case letters.

    public Simtabi\Enekia\Laravel\Traits\Rules\Lowercase::__construct()

## Luhn algorithm

The given value must verify against its included [Luhn algorithm](https://en.wikipedia.org/wiki/Luhn_algorithm) check digit.

    public Simtabi\Enekia\Laravel\Traits\Rules\Luhn::__construct()

## Media (MIME) type

Checks for a valid [Mime Type](https://en.wikipedia.org/wiki/Media_type) (Media type).

    public Simtabi\Enekia\Laravel\Traits\Rules\MimeType::__construct()

## Postal Code

The field under validation must be a [postal code](https://en.wikipedia.org/wiki/Postal_code) of the given country.

    public Simtabi\Enekia\Laravel\Traits\Rules\Postalcode::__construct(string $countrycode)

#### Parameters

**countrycode**

Country code in [ISO-639-1](https://en.wikipedia.org/wiki/ISO_639-1) format.

### Postal Code (static instantiation)

    public static Simtabi\Enekia\Laravel\Traits\Rules\Postalcode::countrycode(string $countrycode): Postalcode

#### Parameters

**countrycode**

Country code in [ISO-639-1](https://en.wikipedia.org/wiki/ISO_639-1) format.

### Postal Code (static instantiation with callback)

    public static Simtabi\Enekia\Laravel\Traits\Rules\Postalcode::resolve(callable $callback): Postalcode

#### Parameters

**callback**

Callback to resolve [ISO-639-1](https://en.wikipedia.org/wiki/ISO_639-1) country code from other source.

### Postal Code (static instantiation with reference)

    public static Simtabi\Enekia\Laravel\Traits\Rules\Postalcode::reference(string $reference): Postalcode

#### Parameters

**reference**

Reference key to get [ISO-639-1](https://en.wikipedia.org/wiki/ISO_639-1) country code from other data in validator.

## Semantic Version Number

The field under validation must be a valid version numbers using [Semantic Versioning](https://semver.org/).

    public Simtabi\Enekia\Laravel\Traits\Rules\SemVer::__construct()

## SEO-friendly short text (Slug)

The field under validation must be a user- and [SEO-friendly short text](https://en.wikipedia.org/wiki/Clean_URL#Slug).

    public Simtabi\Enekia\Laravel\Traits\Rules\Slug::__construct()

## Snake case string

The field under validation must formated as [Snake case](https://en.wikipedia.org/wiki/Snake_case) text.

    public Simtabi\Enekia\Laravel\Traits\Rules\Snakecase::__construct()

## Title case string

The field under validation must formated in [Title case](https://en.wikipedia.org/wiki/Title_case).

    public Simtabi\Enekia\Laravel\Traits\Rules\Titlecase::__construct()

## Universally Unique Lexicographically Sortable Identifier (ULID)

The field under validation must be a valid [Universally Unique Lexicographically Sortable Identifier](https://github.com/ulid/spec).

    public Simtabi\Enekia\Laravel\Traits\Rules\Ulid::__construct()

## Upper case string

The field under validation must be all upper case.

    public Simtabi\Enekia\Laravel\Traits\Rules\Uppercase::__construct()

## Username

The field under validation must be a valid username. Consisting of alpha-numeric characters, underscores, minus and starting with a alphabetic character. Multiple underscore and minus chars are not allowed. Underscore and minus chars are not allowed at the beginning or end.

    public Simtabi\Enekia\Laravel\Traits\Rules\Username::__construct()



### `AuthorizedOnModelAction`

Determine if the user is authorized to perform an ability on an instance of the given model. The id of the model is the field under validation

Consider the following policy:

```php
class ModelPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Model $model): bool
    {
        return $model->user->id === $user->id;
    }
}
```

This validation rule will pass if the id of the logged in user matches the `user_id` on `TestModel` who's it is in the `model_id` key of the request.

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\AuthorizedOnModelAction;

public function rules()
{
    return [
        'model_id' => [new AuthorizedOnModelAction('edit', TestModel::class)],
    ];
}
```

Optionally, you can provide an authentication guard as the third parameter.

```php
new AuthorizedOnModelAction('edit', TestModel::class, 'guard-name')
```

#### Model resolution
If you have implemented the `getRouteKeyName` method in your model, it will be used to resolve the model instance. For further information see [Customizing The Default Key Name](https://laravel.com/docs/7.x/routing)

### `CountryCode`

Determine if the field under validation is a valid [2 letter ISO3166 country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Current_codes) (example of valid country codes: `GB`, `DK`, `NL`).

**Note** that this rule require the package [`league/iso3166`](https://github.com/thephpleague/iso3166) to be installed: `composer require league/iso3166`

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\Country;

public function rules()
{
    return [
        'country_code' => ['required', new Country()],
    ];
}
```

If you want to validate a nullable country code field, you can call the `nullable()` method on the `CountryCode` rule. This way `null` and `0` are also passing values:

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\Country;

public function rules()
{
    return [
        'country_code' => [(new Country())->nullable()],
    ];
}
```

### `Currency`

Determine if the field under validation is a valid [3 letter ISO4217 currency code](https://en.wikipedia.org/wiki/ISO_4217#Active_codes) (example of valid currencies: `EUR`, `USD`, `CAD`).

**Note** that this rule require the package [`league/iso3166`](https://github.com/thephpleague/iso3166) to be installed: `composer require league/iso3166`

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\Currency;

public function rules()
{
    return [
        'currency' => ['required', new Currency()], // Must be present and a valid currency
    ];
}
```

If you want to validate a nullable currency field, simple do not let it be required as described in the [Laravel Docs for implicit validation rules](https://laravel.com/docs/master/validation#implicit-rules):
> ... when an attribute being validated is not present or contains an empty string, normal validation rules, including custom rules, are not run

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\Currency;

public function rules()
{
    return [
        'currency' => [new Currency()], // This will pass for any valid currency, an empty value or null
    ];
}
```
### `ModelsExist`

Determine if all the values in the input array exist as attributes for the given model class.

By default, the rule assumes that you want to validate using `id` attribute. In the example below the validation will pass if all `model_ids` exist for the `Model`.

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\ModelIdsExist;

public function rules()
{
    return [
        'model_ids' => ['array', new ModelIdsExist(Model::class)],
    ];
}
```


You can also pass an attribute name as the second argument. In the example below the validation will pass if there are users for each email given in the `user_emails` of the request.

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\ModelIdsExist;

public function rules()
{
    return [
        'user_emails' => ['array', new ModelIdsExist(User::class, 'emails')],
    ];
}
```

### `Delimited`

This rule can validate a string containing delimited values. The constructor accepts a rule that is used to validate all separate values.

Here's an example where we are going to validate a string containing comma separated email addresses.

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\Delimited;

public function rules()
{
    return [
        'emails' => [new Delimited('email')],
    ];
}
```

Here's some example input that passes this rule:

- `'sebastian@example.com, alex@example.com'`
- `''`
- `'sebastian@example.com'`
- `'sebastian@example.com, alex@example.com, brent@example.com'`
- `' sebastian@example.com   , alex@example.com  ,   brent@example.com  '`

This input will not pass:
- `'@example.com'`
- `'nocomma@example.com nocommatoo@example.com'`
- `'valid@example.com, invalid@'`

#### Setting a minimum
You can set minimum amout of items that should be present:

```php
(new Delimited('email'))->min(2)
```

- `'sebastian@example.com, alex@example.com'` // passes
- `'sebastian@example.com'` // fails

#### Setting a maximum

```php
(new Delimited('email'))->max(2)
```

- `'sebastian@example.com'` // passes
- `'sebastian@example.com, alex@example.com, brent@example.com'` // fails

#### Allowing duplicate items

By default the rule will fail if there are duplicate items found.

- `'sebastian@example.com, sebastian@example.com'` // fails

You can allowing duplicate items like this:

```php
(new Delimited('numeric'))->allowDuplicates()
```

Now this will pass: `1,1,2,2,3,3`

#### Customizing the separator

```php
(new Delimited('email'))->separatedBy(';')
```

- `'sebastian@example.com; alex@example.com; brent@example.com'` // passes
- `'sebastian@example.com, alex@example.com, brent@example.com'` // fails

#### Skip trimming of items

```php
(new Delimited('email'))->doNotTrimItems()
```

- `'sebastian@example.com,freek@example.com'` // passes
- `'sebastian@example.com, freek@example.com'` // fails
- `'sebastian@example.com , freek@example.com'` // fails

#### Composite rules

The constructor of the validator accepts a validation rule string, a validate instance, or an array.

```php
new Delimited('email|max:20')
```
- `'short@example.com'` // passes
- `'invalid'` // fails
- `'loooooooonnnggg@example.com'` // fails

#### Passing custom error messages

The constructor of the validator accepts a custom error messages array as second parameter.

```php
// in a `FormRequest`

use Simtabi\Enekia\Laravel\Traits\Rules\Delimited;

public function rules()
{
    return [
        'emails' => [new Delimited('email', $this->messages())],
    ];
}

public function messages()
{
    return [
        'emails.email' => 'Not all the given e-mails are valid.',
    ];
}
```

# Laravel Model Exists Rule

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mvanduijker/laravel-model-exists-rule.svg?style=flat-square)](https://packagist.org/packages/mvanduijker/laravel-model-exists-rule)
![Build Status](https://github.com/mvanduijker/laravel-model-exists-rule/workflows/Run%20tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/mvanduijker/laravel-model-exists-rule.svg?style=flat-square)](https://packagist.org/packages/mvanduijker/laravel-model-exists-rule)


Laravel validation rule to check if a model exists.

You want to use this rule if the standard laravel `Rule::exists('table', 'column')` is not powerful enough.
When you want to add joins to your exist rule, or the advanced Eloquent\Builder features like whereHas this might be for you.


## Installation

You can install the package via composer:

```bash
composer require mvanduijker/laravel-model-exists-rule
```

## Usage

Simple

```php
<?php

use Duijker\LaravelModelExistsRule\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class ExampleUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                new ModelExists(\App\Models\User::class, 'id'),        
            ],
        ];
    }
}
```

Advanced

```php
<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExampleUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                Rule::modelExists(\App\Models\User::class, 'id', function (Builder $query) {
                    $query->whereHas('role', function (Builder $query) {
                        $query->whereIn('name', ['super-admin', 'admin']);
                    });                    
                }),        
            ],
        ];
    }
}
```



### ExtendedRFC3339
PHP doesn't validate correctly RFC3339: https://github.com/laravel/framework/issues/35387
* for example `2020-12-21T23:59:59+00:00` or `2020-12-21T23:59:59Z` return `false` but it is `true`.

this *Rule* uniform the date in format: `YYYY-MM-DDThh:mm:ss.mmm+nn:nn`

## Usage
```php
<?php
namespace App\Api\Controllers;
use App\Http\Controllers\Controller;

use Simtabi\Enekia\Laravel\Traits\Rules\ExtendedRFC3339;

class MyController extends Controller
{
    public function index()
    {
        $myData = ['starttime' => '2022-04-06T12:00:00.123+00:00']
        Validator::make($myData, [
            'starttime'           => [new ExtendedRFC3339()],
        ])->validate();
    }
}
```




# Laravel Profanity Validator

```php
<?php
// ...
use Simtabi\Enekia\Laravel\Traits\Rules\Profanity;

class MyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', new Profanity()]
        ]);

        // ...
    }
}
```

The validator will load the default locale in your `config/app.php` file configuration which by is `en`. **If your locale is not supported, please [post an issue for this project](https://github.com/arandilopez/laravel-profane/issues)**

If you want to use others dictionaries you can pass them as parameters in the validator.

```php
<?php
// ...
use Simtabi\Enekia\Laravel\Traits\Rules\Profanity;

class MyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', new Profanity('en', 'es')]
        ]);

        // ...
    }
}
```

You can also send as parameter a path of a file which is a dictionary in order to replace the default dictionary or **add a new non supported locale**.

```php
<?php
// ...
use Simtabi\Enekia\Laravel\Traits\Rules\Profanity;

class MyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', new Profanity('en', 'es', resource_path('lang/fr/dict.php'))]
        ]);

        // ...
    }
}
```

#### Strict validation

Now you can strictly validate the exact profane word in the content.

```php
<?php
// ...
use Simtabi\Enekia\Laravel\Traits\Rules\Profanity;

class MyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', (new Profanity())->validateStrictly(true)]
        ]);

        // ...
    }
}
```




# Laravel Password History Validation

## Usage
This package will observe the created and updated event of the models (check the config file for settings) and records the password hashes automatically.

In Your Form Request or Inline Validation, All You Need To Do Is Instantiate The `Password` class passing the current user as an argument
```php
<?php
use Simtabi\Enekia\Laravel\Traits\Rules\Password;

$this->validate($request, [
            'password' => [
                'required', (new Password())->checkIfUsedBefore($request->user())
            ]
        ]);
```

### Cleaning Up Old Record - (Optional)

Because We Are Storing The Hashed Password In Your Database, Your Database Can Get Long When You Have Lots Of Users

Add PasswordHistoryTrait To Your User Model
```php
<?php
use Simtabi\Enekia\Laravel\Traits\HasPasswordHistory;
use Illuminate\Auth\Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasPasswordHistory;

}
```
Then You Can Run The Following Artisan Command

``` bash
php artisan enekia:password-history:clear
```




## License

Intervention Validation is licensed under the [MIT License](http://opensource.org/licenses/MIT).




## Credits
## Credits

- [Riccardo Dalla Via](https://github.com/riccardodallavia)
- [All Contributors](../../contributors)
https://github.com/crazybooot/base64-validation
https://github.com/Rackbeat/laravel-validate-https
https://github.com/illuminatech/validation-composite
https://github.com/arifszn/laravel-advanced-validation
https://github.com/DivineOmega/laravel-password-exposed-validation-rule
https://github.com/brokeyourbike/money-validation-laravel
https://github.com/spatie/laravel-validation-rules
https://github.com/mvanduijker/laravel-model-exists-rule
https://github.com/arandilopez/laravel-profane
https://github.com/maize-tech/laravel-remote-rule
https://github.com/sandervankasteel/laravel-extended-validation
- https://github.com/r4kib/validate-credit-card
- https://github.com/aman00323/email-checker
- https://github.com/tagmood/Laravel-Disposable-Phone
- https://github.com/Propaganistas/Laravel-Disposable-Email
- https://github.com/attla/disposable
- https://github.com/aman00323/email-checker
- https://github.com/romanzipp/Laravel-Validator-Pizza
- https://github.com/KennedyTedesco/Validation
