# Validation Rule to ensure a url is secured (https)

Should be combined with `url` rule. Alternatively just run `Illuminate\Support\Str::startsWith('https://')`

### Class

```php
use Simtabi\Enekia\Laravel\Traits\Rules\Https;

'url' => [
    'url', new Https(),
],
```

### Helper

```php
'url' => [ 'url', 'https' ],
```