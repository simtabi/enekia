<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels;

use Illuminate\Database\Eloquent\Builder;

trait ModelExists
{
    /**
     * @var string
     */
    private $modelClass;

    /**
     * @var string
     */
    private $modelAttribute;

    /**
     * @var callable
     */
    private $closure;

    protected bool $checkIfModelExists = false;

    public function checkIfModelExists(string $modelClass, string $modelAttribute = null, callable $closure = null): static
    {
        $this->checkIfModelExists = true;
        $this->modelClass         = $modelClass;
        $this->modelAttribute     = $modelAttribute ?: (new $modelClass)->getKeyName();
        $this->closure            = $closure ?? function () {};

        return $this;
    }

    public function validateIfModelExists($attribute, $value): bool
    {
        $this->value = $value;

        return $this->modelClass::query()
            ->when(
                is_array($value),
                function (Builder $query) {
                    $query->whereIn($this->modelAttribute, $this->value);
                },
                function (Builder $query) {
                    $query->where($this->modelAttribute, $this->value);
                }
            )
            ->tap($this->closure)
            ->exists();
    }

}