# Enekia

Enekia is data validation library for Laravel's own validation system. The package adds rules to validate data like IBAN, BIC, ISBN, creditcard numbers and more.

## Installation

You can install this package quick and easy with Composer.

Require the package via Composer:

    $ composer require simtabi/enekia

## Laravel integration

The Validation library is built to work with the Laravel Framework (>=7). It comes with a service provider, which will be discovered automatically and registers the validation rules into your installation. The package provides 30 additional validation rules including error messages.

```php
use Illuminate\Support\Facades\Validator;
use Simtabi\Enekia\Rules\CardNumberBasic;
use Simtabi\Enekia\Rules\HexColor;
use Simtabi\Enekia\Rules\Username;

$validator = Validator::make($request->all(), [
    'color' => new Hexcolor(3), // pass rule as object
    'name' => ['required', 'min:3', 'max:20', new Username()], // combining rules works as well
]);
```

**Make sure to pass any of the additional validation rules as objects and not as strings.** 

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
use Simtabi\Enekia\Rules\CardNumberBasic;
use Simtabi\Enekia\Exceptions\ValidationException;

// use static factory method to create laravel validator
$validator = Validator::make($request->all(), [
    'ccnumber' => new CardNumberBasic(),
    'iban' => ['required', new Iban()],
]);

// validate single values by calling static methods
$result = Validator::isHexcolor('foobar'); // false
$result = Validator::isHexcolor('#ccc'); // true
$result = Validator::isBic('foo'); // false

// assert single values
try {
    Validator::assertHexcolor('foobar');
} catch (ValidationException $e) {
    $message = $e->getMessage();
}
```

# Available Rules

The following validation rules are available with this package.

## Base64 encoded string

The field under validation must be [Base64 encoded](https://en.wikipedia.org/wiki/Base64).

    public Simtabi\Enekia\Rules\Base64::__construct()

## Business Identifier Code (BIC)

Checks for a valid [Business Identifier Code](https://en.wikipedia.org/wiki/ISO_9362) (BIC).

    public Simtabi\Enekia\Rules\Bic::__construct()

## Camel case string

The field under validation must be a formated in [Camel case](https://en.wikipedia.org/wiki/Camel_case).

    public Simtabi\Enekia\Rules\Camelcase::__construct()

## Classless Inter-Domain Routing (CIDR) 

Check if the value is a [Classless Inter-Domain Routing](https://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing) notation (CIDR).

    public Simtabi\Enekia\Rules\Cidr::__construct()

## CardNumberBasic

The field under validation must be a valid [creditcard number](https://en.wikipedia.org/wiki/Payment_card_number).

    public Simtabi\Enekia\Rules\CreditCard\CardNumberBasic::__construct()

## Data URI scheme

The field under validation must be a valid [Data URI](https://en.wikipedia.org/wiki/Data_URI_scheme).

    public Simtabi\Enekia\Rules\DataUri::__construct()

## Domain name 

The field under validation must be a well formed [domainname](https://en.wikipedia.org/wiki/Domain_name).

    public Simtabi\Enekia\Rules\Domainname::__construct()

## European Article Number (EAN)

Checks for a valid [European Article Number](https://en.wikipedia.org/wiki/International_Article_Number).

    public Simtabi\Enekia\Rules\Ean::__construct(?int $length = null)

#### Parameters

**length**

Optional integer length (8 or 13) to check only for EAN-8 or EAN-13.

## Global Trade Item Number (GTIN)

Checks for a valid [Global Trade Item Number](https://en.wikipedia.org/wiki/Global_Trade_Item_Number).

    public Simtabi\Enekia\Rules\Gtin::__construct(?int $length = null)

#### Parameters

**length**

Optional integer length to check only for certain types (GTIN-8, GTIN-12, GTIN-13 or GTIN-14).

## Hexadecimal color code

The field under validation must be a valid [hexadecimal color code](https://en.wikipedia.org/wiki/Web_colors). 

    public Simtabi\Enekia\Rules\HexColor::__construct(?int $length = null)

#### Parameters

**length**

Optional length as integer to check only for shorthand (3 characters) or full hexadecimal (6 characters) form.

## Text without HTML

The field under validation must be free of any html code.

    public Simtabi\Enekia\Rules\HtmlClean::__construct()

## International Bank Account Number (IBAN)

Checks for a valid [International Bank Account Number](https://en.wikipedia.org/wiki/International_Bank_Account_Number) (IBAN).

    public Simtabi\Enekia\Rules\Iban::__construct()

## International Mobile Equipment Identity (IMEI) 

The field under validation must be a [International Mobile Equipment Identity](https://en.wikipedia.org/wiki/International_Mobile_Equipment_Identity) (IMEI).

    public Simtabi\Enekia\Rules\Imei::__construct()

## International Standard Book Number (ISBN)

The field under validation must be a valid [International Standard Book Number](https://en.wikipedia.org/wiki/International_Standard_Book_Number) (ISBN).

    public Simtabi\Enekia\Rules\Isbn::__construct(?int $length = null)

#### Parameters

**length**

Optional length parameter as integer to check only for ISBN-10 or ISBN-13.

## International Securities Identification Number (ISIN) 

Checks for a valid [International Securities Identification Number](https://en.wikipedia.org/wiki/International_Securities_Identification_Number) (ISIN).

    public Simtabi\Enekia\Rules\Isin::__construct()

## International Standard Serial Number (ISSN)

Checks for a valid [International Standard Serial Number](https://en.wikipedia.org/wiki/International_Standard_Serial_Number) (ISSN).

    public Simtabi\Enekia\Rules\Issn::__construct()

## JSON Web Token (JWT)

The given value must be a in format of a [JSON Web Token](https://en.wikipedia.org/wiki/JSON_Web_Token).

    public Simtabi\Enekia\Rules\Jwt::__construct()

## Kebab case string

The given value must be formated in [Kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles).

    public Simtabi\Enekia\Rules\Kebabcase::__construct()

## Lower case string 

The given value must be all lower case letters.

    public Simtabi\Enekia\Rules\Lowercase::__construct()

## Luhn algorithm

The given value must verify against its included [Luhn algorithm](https://en.wikipedia.org/wiki/Luhn_algorithm) check digit.

    public Simtabi\Enekia\Rules\Luhn::__construct()

## MAC address 

The field under validation must be a [media access control address](https://en.wikipedia.org/wiki/MAC_address) (MAC address).

    public Simtabi\Enekia\Rules\MacAddress::__construct()

## Media (MIME) type

Checks for a valid [Mime Type](https://en.wikipedia.org/wiki/Media_type) (Media type).

    public Simtabi\Enekia\Rules\MimeType::__construct()

## Postal Code

The field under validation must be a [postal code](https://en.wikipedia.org/wiki/Postal_code) of the given country.

    public Simtabi\Enekia\Rules\Postalcode::__construct(string $countrycode)

#### Parameters

**countrycode**

Country code in [ISO-639-1](https://en.wikipedia.org/wiki/ISO_639-1) format.

### Postal Code (static instantiation)

    public static Simtabi\Enekia\Rules\Postalcode::countrycode(string $countrycode): Postalcode

#### Parameters

**countrycode**

Country code in [ISO-639-1](https://en.wikipedia.org/wiki/ISO_639-1) format.

### Postal Code (static instantiation with callback)

    public static Simtabi\Enekia\Rules\Postalcode::resolve(callable $callback): Postalcode

#### Parameters

**callback**

Callback to resolve [ISO-639-1](https://en.wikipedia.org/wiki/ISO_639-1) country code from other source.

### Postal Code (static instantiation with reference)

    public static Simtabi\Enekia\Rules\Postalcode::reference(string $reference): Postalcode

#### Parameters

**reference**

Reference key to get [ISO-639-1](https://en.wikipedia.org/wiki/ISO_639-1) country code from other data in validator.

## Semantic Version Number

The field under validation must be a valid version numbers using [Semantic Versioning](https://semver.org/).

    public Simtabi\Enekia\Rules\SemVer::__construct()

## SEO-friendly short text (Slug)

The field under validation must be a user- and [SEO-friendly short text](https://en.wikipedia.org/wiki/Clean_URL#Slug).

    public Simtabi\Enekia\Rules\Slug::__construct()

## Snake case string

The field under validation must formated as [Snake case](https://en.wikipedia.org/wiki/Snake_case) text.

    public Simtabi\Enekia\Rules\Snakecase::__construct()

## Title case string

The field under validation must formated in [Title case](https://en.wikipedia.org/wiki/Title_case).

    public Simtabi\Enekia\Rules\Titlecase::__construct()

## Universally Unique Lexicographically Sortable Identifier (ULID)

The field under validation must be a valid [Universally Unique Lexicographically Sortable Identifier](https://github.com/ulid/spec).

    public Simtabi\Enekia\Rules\Ulid::__construct()

## Upper case string

The field under validation must be all upper case.

    public Simtabi\Enekia\Rules\Uppercase::__construct()

## Username

The field under validation must be a valid username. Consisting of alpha-numeric characters, underscores, minus and starting with a alphabetic character. Multiple underscore and minus chars are not allowed. Underscore and minus chars are not allowed at the beginning or end.

    public Simtabi\Enekia\Rules\Username::__construct()

## LocationCoordinates

Requires that the given value is a comma-separated set of latitude and longitude coordinates

    public Simtabi\Enekia\Rules\Localization\LocationCoordinates::__construct()

## EncodedImage

Requires that the given value is a base64-encoded image of a given mime types - see class for details

    public Simtabi\Enekia\Rules\EncodedImage::__construct()

## CitizenshipIdentificationNumber

Requires that the given value is a base64-encoded image of a given mime types - see class for details

    public Simtabi\Enekia\Rules\CitizenshipIdentificationNumber::__construct()

## OddNumber

Requires that the given value is an odd number (decimals are first converted using intval)

    public Simtabi\Enekia\Rules\OddNumber::__construct()

## EvenNumber

Requires that the given value is an even number (decimals are first converted using intval)

    public Simtabi\Enekia\Rules\EvenNumber::__construct()

## FileExists

Requires that the given value is a path to an existing file - see class for details

    public Simtabi\Enekia\Rules\FileExists::__construct()

## DisposableEmail

Requires the presence of an email address which is not disposable. By default, if the API fails to load, the email will be accepted. However, you can override this by adding a boolean parameter e.g. new DisposableEmail(true).

    public Simtabi\Enekia\Rules\DisposableEmail::__construct()

## Decimal

Requires that the given value is a decimal with an appropriate format - see class for details

    public Simtabi\Enekia\Rules\Decimal::__construct()

## Equals

Requires that the given value is equal to another given value

    public Simtabi\Enekia\Rules\Equals::__construct()

## EndsWith

Requires that the given value ends with a given string - see class for details

    public Simtabi\Enekia\Rules\EndsWith::__construct()

## NoWhitespace

Requires that the given value not include any whitespace characters

    public Simtabi\Enekia\Rules\NoWhitespace::__construct()

## DoesNotExist

Requires that the given value is not present in a given database table / column - see class for details

    public Simtabi\Enekia\Rules\DoesNotExist::__construct()

## CurrencySymbol

Requires the presence of a monetary figure e.g $72.33 - see class for details

    public Simtabi\Enekia\Rules\CurrencySymbol::__construct()

## Domain

Requires that the given value be a domain e.g. google.com, www.google.com

    public Simtabi\Enekia\Rules\Domain::__construct()

## MaxWords

Requires that the given value cannot contain more words than specified

    public Simtabi\Enekia\Rules\MaxWords::__construct()

## ExcludesHtml

Requires that the given value doesn't contain Html tags

    public Simtabi\Enekia\Rules\ExcludesHtml::__construct()

## IncludesHtml

Requires that the given value contains Html tags

    public Simtabi\Enekia\Rules\IncludesHtml::__construct()

## StringContains

Requires that the given value contains the given values

    public Simtabi\Enekia\Rules\StringContains::__construct()

## Base64EncodedString

Requires that the given value is a base64 encoded string

    public Simtabi\Enekia\Rules\Base64EncodedString::__construct()

## Coordinate

Requires that the given value has valid coordinates

    public Simtabi\Enekia\Rules\Coordinate::__construct()

## DomainRestrictedEmail

Requires that the given value is a valid domain restricted email

    public Simtabi\Enekia\Rules\DomainRestrictedEmail::__construct()

## HexColourCode

Requires that the given value is a valid hex color code

    public Simtabi\Enekia\Rules\HexColourCode::__construct()

## NumberParity

Requires that the given value has valid parity

    public Simtabi\Enekia\Rules\NumberParity::__construct()

## Salutation

Requires that the given value is a valid salutation

    public Simtabi\Enekia\Rules\Salutation::__construct()


## VatNumber

Requires that the given value is a valid VAT number

    public Simtabi\Enekia\Rules\VatNumber::__construct()


## Contains

Requires that the given value contains a given value

    public Simtabi\Enekia\Rules\Contains::__construct()


## DateAfterOrEqual

Requires that the given value is a date and it's after or equal

    public Simtabi\Enekia\Rules\DateAfterOrEqual::__construct()


## DateBeforeOrEqual

Requires that the given value is a date and it's before or equal

    public Simtabi\Enekia\Rules\DateBeforeOrEqual::__construct()


## DateHasSpecificMinutes

Requires that the given value is a date and has specific minutes

    public Simtabi\Enekia\Rules\DateHasSpecificMinutes::__construct()


## Hostname

Requires that the given value is a valid hostname i.e google.com

    public Simtabi\Enekia\Rules\Hostname::__construct()


## Interval

Requires that the given value is a valid interval, i.e. PT30S.

    public Simtabi\Enekia\Rules\Interval::__construct()


## MaximumHourDifference

Requires that the given value has a maximum hour difference

    public Simtabi\Enekia\Rules\MaximumHourDifference::__construct()


## NotContains

Requires that the given value does not contain a given value

    public Simtabi\Enekia\Rules\NotContains::__construct()


## NotEndsWith

Requires that the given value does not end with a given value

    public Simtabi\Enekia\Rules\NotEndsWith::__construct()


## NotStartsWith

Requires that the given value does not start with a given value

    public Simtabi\Enekia\Rules\NotStartsWith::__construct()


## PositiveInterval

Requires that the given value is a positive interval

    public Simtabi\Enekia\Rules\PositiveInterval::__construct()


## Price

Requires that the given value is a valid price

    public Simtabi\Enekia\Rules\Price::__construct()


## SecureUrl

Requires that the given value is a valid secure url

    public Simtabi\Enekia\Rules\SecureUrl::__construct()


## Phone

Requires that the given value is a valid phone number

    public Simtabi\Enekia\Rules\Phone::__construct()


## PostalCodeDutch

Requires that the given value is a valid dutch postal code

    public Simtabi\Enekia\Rules\PostalCodeDutch::__construct()


## Timezone

Requires that the given value is a valid timezone

    public Simtabi\Enekia\Rules\Localization\Timezone::__construct()


## Language

Requires that the given value is a valid language using iso codes, nd or names

    public Simtabi\Enekia\Rules\Localization\Language::__construct()


# IP Address

Validates an ip address is either public or private. Supports ipv4 & ipv6.

## Usage

Validate an ip address is a public address.

```php
use Simtabi\Enekia\Rules\IpAddress;

$request->validate([
    'ip' => ['required', new PublicIpAddress],
]);
```

Validate an ip address is a private address.

```php
use Simtabi\Enekia\Rules\IpAddress;

$request->validate([
    'ip' => ['required', new PrivateIpAddress],
]);
```



## Subdomain

### Usage

```php
use Simtabi\Enekia\Rules\Subdomain;

$request->validate([
    'domain' => ['required', new Subdomain],
]);
```


## IsOffensiveWord
### Usage

The following code snippet shows an example of how to use the offensive validation rule.

```php
use Simtabi\Enekia\Rules\IsOffensiveWord;

$request->validate([
    'username' => ['required', new Offensive],
]);
```



## IsAStateInNorthAmerica
### Usage

The following code snippet shows an example of how to use the north america state validation rule.

```php
use Simtabi\Enekia\Rules\Localization\IsAStateInNorthAmerica;

$request->validate([
    'state' => ['required', new IsAStateInNorthAmerica('US')->doAbbreviatedName()],
]);
```




## ModelsExists
### `ModelsExists`
### Usage

Determine if all of the values in the input array exist as attributes for the given model class.

By default the rule assumes that you want to validate using `id` attribute. In the example below the validation will pass if all `model_ids` exist for the `Model`.

```php
// in a `FormRequest`

use Simtabi\Enekia\Rules\ModelsExists;

public function rules()
{
    return [
        'model_ids' => ['array', new ModelsExists(Model::class)],
    ];
}
```


You can also pass an attribute name as the second argument. In the example below the validation will pass if there are users for each email given in the `user_emails` of the request.

```php
// in a `FormRequest`

use Simtabi\Enekia\Rules\ModelsExists;

public function rules()
{
    return [
        'user_emails' => ['array', new ModelsExists(User::class, 'emails')],
    ];
}
```


## Authorized
### `Authorized`

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

use Simtabi\Enekia\Rules\Authorized;

public function rules()
{
    return [
        'model_id' => [new Authorized('edit', TestModel::class)],
    ];
}
```

Optionally, you can provide an authentication guard as the third parameter.

```php
new Authorized('edit', TestModel::class, 'guard-name')
```

#### Model resolution
If you have implemented the `getRouteKeyName` method in your model, it will be used to resolve the model instance. For further information see [Customizing The Default Key Name](https://laravel.com/docs/7.x/routing)





## Country
### `Country`

Determine if the field under validation is a valid [2 letter ISO3166 country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Current_codes) (example of valid country codes: `GB`, `DK`, `NL`).

**Note** that this rule require the package [`league/iso3166`](https://github.com/thephpleague/iso3166) to be installed: `composer require league/iso3166`

```php
// in a `FormRequest`

use Simtabi\Enekia\Rules\Localization\Country;

public function rules()
{
    return [
        'country_code' => ['required', new Country()->doIso2()],
    ];
}
```

If you want to validate a nullable country code field, you can call the `nullable()` method on the `CountryCode` rule. This way `null` and `0` are also passing values:

```php
// in a `FormRequest`

use Simtabi\Enekia\Rules\Localization\Country;

public function rules()
{
    return [
        'country_code' => [(new Country())->doIso2()->nullable()],
    ];
}
```



## Enum

This rule will validate if the value under validation is part of the given enum class. We assume that the enum class has a static `toArray` method that returns all valid values. If you're looking for a good enum class, take a look at [spatie/enum](https://github.com/spatie/enum) or [myclabs/php-enum](https://github.com/myclabs/php-enum).

Consider the following enum class:

```php
class UserRole extends MyCLabs\Enum\Enum
{
    const ADMIN = 'admin';
    const REVIEWER = 'reviewer';
}
```

The `Enum` rule can be used like this:

```php
// in a `FormRequest`

use Simtabi\Enekia\Rules\Enum;

public function rules()
{
    return [
        'role' => [new Enum(UserRole::class)],
    ];
}
```



## CurrencyCode
### Usage — still WIP

Determine if the field under validation is a valid [3 letter ISO4217 currency code](https://en.wikipedia.org/wiki/ISO_4217#Active_codes) (example of valid currencies: `EUR`, `USD`, `CAD`).

**Note** that this rule require the package [`league/iso3166`](https://github.com/thephpleague/iso3166) to be installed: `composer require league/iso3166`

```php
// in a `FormRequest`

use Simtabi\Enekia\Rules\Currency;

public function rules()
{
    return [
        'currency' => ['required', new Currency()->doNumericCode()], // Must be present and a valid currency
    ];
}
```

If you want to validate a nullable currency field, simple do not let it be required as described in the [Laravel Docs for implicit validation rules](https://laravel.com/docs/master/validation#implicit-rules):
> ... when an attribute being validated is not present or contains an empty string, normal validation rules, including custom rules, are not run

```php
// in a `FormRequest`

use Simtabi\Enekia\Rules\Currency;

public function rules()
{
    return [
        'currency' => [new Currency()->doNumericCode()], // This will pass for any valid currency, an empty value or null
    ];
}
```


### `Delimited`

This rule can validate a string containing delimited values. The constructor accepts a rule that is used to validate all separate values.

Here's an example where we are going to validate a string containing comma separated email addresses.

```php
// in a `FormRequest`

use Simtabi\Enekia\Rules\Delimited;

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

use Simtabi\Enekia\Rules\Delimited;

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




### Custom word lists

If the defaults are too strict (or not strict enough), you can optionally specify a custom list
of offensive words and custom whitelist. Below is an example of using a custom blacklist and whitelist.

```php
use Simtabi\Enekia\Rules\IsOffensiveWord;
use Simtabi\Enekia\Support\OffensiveWordChecker;

$blacklist = ['moist', 'stinky', 'poo'];
$whitelist = ['poop'];

$request->validate([
    'username' => ['required', new Offensive(new OffensiveWordChecker($blacklist, $whitelist))],
]);
```



-----














---------
## Available Rules

### BicNumber

Validates the provided [BIC number](https://www.betaalvereniging.nl/en/focus/giro-based-and-online-payments/bank-identifier-code-bic-for-sepa-transactions/).

### Contains

Validates if the value contains a certain phrase.

```php
'field' => [new Contains($needle)],
```

### DateAfterOrEqual

Validates if the value is a date after or equals the provided date (Carbon).

```php
'field' => [new DateAfterOrEqual($date)],
```

### DateBeforeOrEqual

Validates if the value is a date before or equals the provided date (Carbon).

```php
'field' => [new DateBeforeOrEqual($date)],
```

### DateHasSpecificMinutes

Validates if the selected minutes for the provided date are according to the available minutes.

```php
'field' => [new DateHasSpecificMinutes([0, 15, 30, 45])],
```

When the date is not according to the 'Y-m-d H:i' format then you are able to specify the format as second parameter:

```php
'field' => [new DateHasSpecificMinutes([0, 15, 30, 45], 'd-m-Y H:i')],
```

### DutchPhone

Validates if the value is a valid dutch phone number. Both mobile or landlines are supported. See the `Phone` validation
rule to validate a phone number which isn't limited to the Netherlands.

### PostalCodeDutch

Validates if the value is a valid dutch zip code, like `1234AB`.

### HexColor

Validates if the value contains a hex color, like `#000000`.

### HostName

Validates if the value contains a valid hostname, like `example.com`.

### InternationalBankAccountNumber

Validates if the value contains a valid [IBAN](https://en.wikipedia.org/wiki/International_Bank_Account_Number).

### Interval

Validates if the value is an interval, i.e. `PT30S`.

### MaximumHourDifference

Validates if the value is differing less then the provided amount of hours.

```php
'field' => [new MaximumHourDifference($start, 10)];
```

### Mime Type

Validates if the value is valid MIME.

### NotContains

Validates if the value *NOT* contains a certain phrase.

```php
'field' => [new NotContains($needle)],
```

### NotEndsWith

Validates if the value *NOT* ends with a certain phrase.

```php
'field' => [new NotEndsWith($needle)],
```

### NotStartsWith

Validates if the value *NOT* starts with a certain phrase.

```php
'field' => [new NotEndsWith($needle)],
```

## Password strength

Validates if the value contains at least a letter, a capital and a number.

### Phone

Validates if the value is a valid phone number.

### Positive interval

Validates if the value is an interval and the interval is positive.

### Price

Validates if the value is a valid price. The rule optionally accepts a specific decimal sign. When the decimal isn't
provided it accepts both `,` or `.` signs.

```php
'field' => [new Price()], // accepts both , and .
'field' => [new Price(',')], // accepts only ,
```

### Secure url

Validates if the value is a valid secure url, i.e. is a HTTPS url.

### Semver

Validates if the value is a valid version according to the [Semver](https://semver.org/) standard.

### VatNumber

Validates if the value is a valid formatted VAT number.

**Be aware**: It doesn't check if the number is known in the VAT database. If you need to know the VAT number is truly
legit, I'm currently offering an easy to use (paid) service for that.

---------


---------



## Usage

As discussed in the official [Laravel documentation](https://laravel.com/docs/master/validation#using-rule-objects), import the required rule whenever required:

```php
use Simtabi\Enekia\Rules\TitleCase;

// ...

$request->validate([
    'team' => ['required', new TitleCase()],
]);
```

Alternatively use the rule directly with a [Laravel form request object](https://laravel.com/docs/7.x/validation#form-request-validation)

## Available rules

- [`Base64EncodedString`](#base64encodedstring)
- [`Coordinate`](#coordinate)
- [`DomainRestrictedEmail`](#domainrestrictedemail)
- [`ExcludesHtml`](#excludeshtml)
- [`HexColourCode`](#hexcolourcode)
- [`Honorific`](#honorific)
- [`IncludesHtml`](#includeshtml)
- [`NoWhitespace`](#nowhitespace)
- [`NumberParity`](#numberparity)
- [`StringContains`](#stringcontains)
- [`StrongPassword`](#strongpassword)
- [`TitleCase`](#titlecase)
- [`UKMobilePhone`](#ukmobilephone)
- [`Uppercase`](#uppercase)

### `Base64EncodedString`

Ensure the passed attribute is a valid base 64 encoded string.

### `Coordinate`

Ensure the passed attribute is a valid comma separated Latitude and Longitude string. For example: `51.507877,-0.087732`.

### `DomainRestrictedEmail`

Ensure the passed email in question is part of the provided whitelist of domains.

For instance, to ensure the given email domain is `f9web.co.uk` or `laravel.com`:

```php
use Simtabi\Enekia\Rules\DomainRestrictedEmail;

// ...

$request->validate([
    'email' => [
        'required', 
        (new DomainRestrictedEmail())->validDomains([
            'f9web.co.uk',
            'laravel.com',
        ]),
    ],
]);
``` 

The validation message will include the list of whitelisted domains based upon the provided configuration.

### `ExcludesHtml`

Ensure the passed attribute does not contain HTML.

### `HexColourCode`

Ensure the passed attribute is a valid hex colour code (three of six characters in length), optionally validating the presence of the `#` prefix.

Minimum usage example to validate a short length code with the prefix i.e. `#fff`:

```php
use Simtabi\Enekia\Rules\HexColourCode;

(new HexColourCode());
``` 

Extended usage example to validate a long length code , omitting prefix i.e. `cc0000`:

```php
use Simtabi\Enekia\Rules\HexColourCode;

(new HexColourCode())->withoutPrefix()->longFormat();
``` 

### `Honorific`

Ensure the passed attribute is a valid honorific, omitting appended dots. The list of valid honorifics is available [here](src/Support/Honorifics.php).

### `IncludesHtml`

Ensure the passed attribute contains HTML.

### `NoWhitespace`

Ensure the passed attribute contains no whitespace.

### `NumberParity`

Validate the number parity.

An odd number:

```php
use Simtabi\Enekia\Rules\NumberParity;

// ...

$request->validate([
    'amount' => [
        'required', 
        (new NumberParity())->odd(),
    ],
]);
``` 

An even number:

```php
use Simtabi\Enekia\Rules\NumberParity;

// ...

$request->validate([
    'amount' => [
        'required', 
        (new NumberParity())->even(),
    ],
]);
``` 

### `StringContains`

Ensure the given attribute contains the provided strings.

Minimum usage example to ensure the attribute in question contains the string `php` or `laravel`:

```php
use Simtabi\Enekia\Rules\StringContains;

// ...

$request->validate([
    'description' => [
        'required', 
        (new StringContains())->phrases([
            'laravel',
            'php',
        ]),
    ],
]);
``` 

Optionally force the string to contain *all* provided phrases:

```php
use Simtabi\Enekia\Rules\StringContains;

// ...

$request->validate([
    'description' => [
        'required', 
        (new StringContains())->phrases([
            'laravel',
            'php',
        ])->strictly(),
    ],
]);
``` 
The validation message will include the list phrases based upon the provided configuration.

### `StrongPassword`

Ensure the given attribute matches the provided conditions.

Minimum usage example to ensure the attribute:

- is a minimum of eight characters in length
- contains upper and lowercase characters
- contains at least one number

```php
use Simtabi\Enekia\Rules\Password\StrongPassword;

// ...

$request->validate([
    'password' => [
        'required', 
        (new StrongPassword()),
    ],
]);
``` 

Additional methods are available.

```php
use Simtabi\Enekia\Rules\Password\StrongPassword;

// ...

$request->validate([
    'password' => [
        'required', 
        (new StrongPassword())
            ->forceUppercaseCharacters()
            ->forceLowercaseCharacters(false)
            ->forceNumbers()
            ->forceSpecialCharacters()
            // ->withSpecialCharacters('£$*%^'),
    ],
]);
``` 

The default special characters are `!@#$%^&*()\-_=+{};:,<."£~?|>`. Optionally the `withSpecialCharacters()` method can be used to define a custom list.

### `TitleCase`

Ensure the provided attribute is [title case](https://laravel.com/docs/7.x/helpers#method-title-case).

### `UKMobilePhone`

Ensure the provided attribute is a valid UK mobile telephone number.

### `Uppercase`

Ensure the provided attribute is entirely uppercase.







# Credit Card validation
## Usage
### As FormRequest

```php
<?php

namespace App\Http\Requests;

use Simtabi\Enekia\Rules\CreditCard\CardCvc;
use Simtabi\Enekia\Rules\CreditCard\CardNumber;
use Simtabi\Enekia\Rules\CreditCard\CardExpirationYear;
use Simtabi\Enekia\Rules\CreditCard\CardExpirationMonth;
use Illuminate\Foundation\Http\FormRequest;

class CreditCardRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'card_number' => ['required', new CardNumber],
            'expiration_year' => ['required', new CardExpirationYear($this->get('expiration_month'))],
            'expiration_month' => ['required', new CardExpirationMonth($this->get('expiration_year'))],
            'cvc' => ['required', new CardCvc($this->get('card_number'))]
        ];
    }
}
```

### Card number
#### From request

```php
$request->validate(
    ['card_number' => '37873449367100'],
    ['card_number' => new Simtabi\Enekia\Rules\CreditCard\CardNumber]
);
```
#### Directly

```php
(new Simtabi\Enekia\Rules\CreditCard\Cards\Visa)
    ->setCardNumber('4012888888881881')
    ->isValidCardNumber()
```


### Card expiration
#### From request

```php
// CardExpirationYear requires card expiration month
$request->validate(
    ['expiration_year' => '2017'],
    ['expiration_year' => ['required', new Simtabi\Enekia\Rules\CreditCard\CardExpirationYear($request->get('expiration_month'))]]
);

// CardExpirationMonth requires card expiration year
$request->validate(
    ['expiration_month' => '11'],
    ['expiration_month' => ['required', new Simtabi\Enekia\Rules\CreditCard\CardExpirationMonth($request->get('expiration_year'))]]
);

// CardExpirationDate requires date format
$request->validate(
    ['expiration_date' => '02-18'],
    ['expiration_date' => ['required', new Simtabi\Enekia\Rules\CreditCard\CardExpirationDate('MM-YY')]]
);
```
#### Directly

```php
Simtabi\Enekia\Rules\CreditCard\Cards\ExpirationDateValidator(
    $expiration_year,
    $expiration_month
)->isValid();

// Or static
Simtabi\Enekia\Rules\CreditCard\Cards\ExpirationDateValidator::validate(
    $expiration_year,
    $expiration_month
);
```


### Card CVC
#### From request

```php
// CardCvc requires card number to determine allowed cvc length
$request->validate(
    ['cvc' => '123'],
    ['cvc' => new Simtabi\Enekia\Rules\CreditCard\CardCvc($request->get('card_number'))]
);

```
#### Directly

```php
Simtabi\Enekia\Rules\CreditCard\Cards\Card::isValidCvcLength($cvc);
```















## Contribution

Any ideas are welcome. Feel free to submit any issues or pull requests.

## Testing

``` bash
composer test
```

## Security

If you discover any security related issues, please email imani@simtabi.com instead of using the issue tracker.


### Credits & Inspiration
* https://github.com/ewereka/laravel-extra-validation
* https://github.com/Intervention/validation
* https://github.com/mattkingshott/axiom
* https://github.com/f9webltd/laravel-validation-rules
* https://github.com/DivineOmega/laravel-password-exposed-validation-rule
* https://github.com/laravel-validation-rules

### License

Enekia is licensed under the [MIT License](http://opensource.org/licenses/MIT).
