<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Validators\Respect;

use Exception;
use Illuminate\Validation\Validator as BaseValidator;

final class RespectValidator extends BaseValidator
{
    public function __call($method, $parameters)
    {
        try {

            $rule           = mb_substr($method, 8);
            [$value, $args] = [$parameters[1], $parameters[2]];

            return RespectValidationRuleFactory::make($rule, $args)->validate($value);

        } catch (Exception $e) {
            return parent::__call($method, $parameters);
        }
    }
}