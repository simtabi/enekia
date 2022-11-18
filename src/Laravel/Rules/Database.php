<?php

namespace Simtabi\Enekia\Laravel\Rules\Database;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\Rules\Database\LessThanOrEqualValue;
use Simtabi\Enekia\Laravel\Traits\Rules\Database\LessThanValue;
use Simtabi\Enekia\Laravel\Traits\Rules\Database\MoreThanOrEqualValue;
use Simtabi\Enekia\Laravel\Traits\Rules\Database\MoreThanValue;
use Simtabi\Enekia\Laravel\Traits\Rules\Database\MustBeEqualValue;

class Database extends AbstractRule implements Rule
{

    use LessThanOrEqualValue;
    use LessThanValue;
    use MoreThanOrEqualValue;
    use MoreThanValue;
    use MustBeEqualValue;

    public function __construct()
    {
        $this->parameters = func_get_args();

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $this->grabRuleData($attribute, $value);

        if ($this->checkLessThanOrEqualValue){
            return $this->validateLessThanOrEqualValue($attribute, $value);
        }elseif ($this->checkLessThanValue){
            return $this->validateLessThanValue($attribute, $value);
        }elseif ($this->checkMoreThanOrEqualValue){
            return $this->validateMoreThanOrEqualValue($attribute, $value);
        }elseif ($this->checkMoreThanValue){
            return $this->validateMoreThanValue($attribute, $value);
        }elseif ($this->checkMustBeEqualValue){
            return $this->validateMustBeEqualValue($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkLessThanOrEqualValue){
            return [
                'key'        => 'database.less_than_or_equal_value',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkLessThanValue){
            return [
                'key'        => 'database.less_than_value',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'column'    => $this->column,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkMoreThanOrEqualValue){
            return [
                'key'        => 'database.more_than_or_equal_value',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'column'    => $this->column,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkMoreThanValue){
            return [
                'key'        => 'database.more_than_value',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'column'    => $this->column,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkMustBeEqualValue){
            return [
                'key'        => 'database.must_be_equal_value',
                'parameters' => [
                    'attribute'    => $this->attribute,
                    'column'       => $this->column,
                    'found_value'  => $this->foundValue,
                    'posted_value' => $this->postedValue,
                ],
            ];
        }

        return '';
    }
}