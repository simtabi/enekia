<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels;

trait ModelIdsExist
{
    /** @var string */
    protected $modelClassName;

    /** @var string */
    protected $modelAttribute;

    /** @var array */
    protected $modelIds;

    protected bool $checkIfModelIdsExist = false;

    public function checkIfModelIdsExist(string $modelClassName, string $attribute = 'id'): static
    {
        $this->checkIfModelIdsExist = true;
        $this->modelClassName       = $modelClassName;
        $this->modelAttribute       = $attribute;

        return $this;
    }

    public function validateModelIdsExist($attribute, $value): bool
    {
        $this->attribute = $attribute;

        $value           = array_filter($value);

        $this->modelIds  = array_unique($value);

        $modelCount      = $this->modelClassName::whereIn($this->modelAttribute, $this->modelIds)->count();

        return count($this->modelIds) === $modelCount;
    }

}
