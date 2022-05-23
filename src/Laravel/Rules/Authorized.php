<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Simtabi\Enekia\Laravel\AbstractRule;

class Authorized extends AbstractRule implements Rule
{
    /** @var string */
    protected $ability;

    /** @var array */
    protected $arguments;

    /** @var string */
    protected $className;

    /** @var string */
    protected $attribute;

    /** @var string */
    protected $guard;

    public function __construct(string $ability, string $className, string $guard = null)
    {
        $this->className = $className;
        $this->ability   = $ability;
        $this->guard     = $guard;
    }

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        if (! $user = Auth::guard($this->guard)->user()) {
            return false;
        }

        if (! $model = app($this->className)->resolveRouteBinding($value)) {
            return false;
        }

        return $user->can($this->ability, $model);
    }

    public function customMessage(): string
    {
        $classBasename = class_basename($this->className);

        return __('ekenia::messages.authorized', [
            'attribute' => $this->attribute,
            'ability'   => $this->ability,
            'className' => $classBasename,
        ]);
    }
}
