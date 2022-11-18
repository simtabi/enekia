<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels;

use Illuminate\Support\Facades\Auth;

trait AuthorizedOnModelAction
{
    /** @var string */
    protected $ability;

    /** @var array */
    protected $arguments;

    /** @var string */
    protected $className;

    /** @var string */
    protected $guard;

    protected bool $checkIfActionIsAuthorizedOnModel = false;

    public function checkIfActionIsAuthorizedOnModel(string $ability, string $className, string $guard = null): static
    {
        $this->checkIfActionIsAuthorizedOnModel = true;
        $this->ability                          = $ability;
        $this->className                        = $className;
        $this->guard                            = $guard;

        return $this;
    }

    public function validateIfActionIsAuthorizedOnModel($attribute, $value): bool
    {

        if (! $user = Auth::guard($this->guard)->user()) {
            return false;
        }

        if (! $model = app($this->className)->resolveRouteBinding($value)) {
            return false;
        }

        return $user->can($this->ability, $model);
    }

}
