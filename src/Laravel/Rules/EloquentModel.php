<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels\AuthorizedOnModelAction;
use Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels\MissingFromDB;
use Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels\ModelExists;
use Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels\ModelIdsExist;
use Simtabi\Enekia\Laravel\Traits\Rules\EloquentModels\RecordOwner;

class EloquentModel extends AbstractRule implements Rule
{
    use AuthorizedOnModelAction;
    use MissingFromDB;
    use ModelExists;
    use ModelIdsExist;
    use RecordOwner;

    /**
     * Constructor.
     *
     **/
    public function __construct()
    {
        $this->parameters = func_get_args();

        parent::__construct();
    }

    public function passes($attribute, $value) : bool
    {

        if ($this->checkIfActionIsAuthorizedOnModel){
            $this->validateIfActionIsAuthorizedOnModel($attribute, $value);
        }elseif ($this->checkIfIsMissingFromDB){
            $this->validateMissingFromDB($attribute, $value);
        }elseif ($this->checkIfModelExists){
            $this->validateIfModelExists($attribute, $value);
        }elseif ($this->checkIfModelIdsExist){
            $this->validateModelIdsExist($attribute, $value);
        }elseif ($this->checkIfIsRecordOwner){
            $this->validateRecordOwner($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkIfActionIsAuthorizedOnModel){
            return [
                'key'        => 'eloquent_model.action_not_authorized_on_model',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'ability'   => $this->ability,
                    'className' => class_basename($this->className),
                ],
            ];
        } elseif ($this->checkIfIsMissingFromDB){
            return [
                'key'        => 'eloquent_model.missing_from_db',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'ability'   => $this->ability,
                    'className' => class_basename($this->className),
                ],
            ];
        }elseif ($this->checkIfModelExists){
            return [
                'key'        => 'eloquent_model.model_not_found',
                'parameters' => [
                    'value'     => $this->value,
                    'model'     => class_basename($this->modelClass),
                    'attribute' => $this->modelAttribute,
                ],
            ];
        }elseif ($this->checkIfModelIdsExist){
            return [
                'key'        => 'eloquent_model.ids_not_found',
                'parameters' => [
                    'attribute'      => $this->attribute,
                    'model'          => class_basename($this->modelClassName),
                    'modelAttribute' => $this->modelAttribute,
                    'modelIds'       => implode(', ', $this->modelIds),
                ],
            ];
        }elseif ($this->checkIfIsRecordOwner){
            return 'eloquent_model.not_a_record_owner';
        }

        return '';
    }
}