<?php

namespace Simtabi\Enekia\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\AbstractRule;

class ModelsExists extends AbstractRule implements Rule
{
    /** @var string */
    protected $modelClassName;

    /** @var string */
    protected $modelAttribute;

    /** @var array */
    protected $modelIds;

    public function __construct(string $modelClassName, string $attribute = 'id')
    {
        $this->modelClassName = $modelClassName;
        $this->modelAttribute = $attribute;
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        $this->modelIds  = array_unique(array_filter($value));

        return count($this->modelIds) === ($this->modelClassName::whereIn($this->modelAttribute, $this->modelIds)->count());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        $modelIds      = implode(', ', $this->modelIds);
        $classBasename = class_basename($this->modelClassName);

        return __('validation::messages.exists_in_model', [
            'modelAttribute' => $this->modelAttribute,
            'modelIds'       => $modelIds,
            'attribute'      => $this->attribute,
            'model'          => $classBasename,
        ]);
    }
}