# Laravel Validator Rules - Credit Card

## Usage
### As FormRequest

```php
<?php

namespace App\Http\Requests;

use Simtabi\Enekia\Laravel\Validators\CreditCards\CardCvc;
use Simtabi\Enekia\Laravel\Validators\CreditCards\CardNumber;
use Simtabi\Enekia\Laravel\Validators\CreditCards\CardExpirationYear;
use Simtabi\Enekia\Laravel\Validators\CreditCards\CardExpirationMonth;
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
    ['card_number' => new Simtabi\Enekia\Laravel\Validators\CreditCards\CardNumber]
);
```
#### Directly

```php
(new Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Visa)
    ->setCardNumber('4012888888881881')
    ->isValidCardNumber()
```


### Card expiration
#### From request

```php
// CardExpirationYear requires card expiration month
$request->validate(
    ['expiration_year' => '2017'],
    ['expiration_year' => ['required', new Simtabi\Enekia\Laravel\Validators\CreditCards\CardExpirationYear($request->get('expiration_month'))]]
);

// CardExpirationMonth requires card expiration year
$request->validate(
    ['expiration_month' => '11'],
    ['expiration_month' => ['required', new Simtabi\Enekia\Laravel\Validators\CreditCards\CardExpirationMonth($request->get('expiration_year'))]]
);

// CardExpirationDate requires date format
$request->validate(
    ['expiration_date' => '02-18'],
    ['expiration_date' => ['required', new Simtabi\Enekia\Laravel\Validators\CreditCards\CardExpirationDate('my')]]
);
```
#### Directly

```php
Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\ExpirationDateValidator(
    $expiration_year,
    $expiration_month
)->isValid();

// Or static
Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\ExpirationDateValidator::validate(
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
    ['cvc' => new Simtabi\Enekia\Laravel\Validators\CreditCards\CardCvc($request->get('card_number'))]
);

```
#### Directly

```php
Simtabi\Enekia\Laravel\Validators\CreditCards\Cards\Card::isValidCvcLength($cvc);
```


### License
This project is licensed under an Apache 2.0 license which you can find
[in this LICENSE](https://github.com/laravel-validation-rules/credit-card/blob/master/LICENSE).


### Feedback
If you have any feedback, comments or suggestions, please feel free to open an
issue within this repository!
