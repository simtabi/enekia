<?php declare(strict_types=1);

namespace Simtabi\Laranail\Helpers;

use Illuminate\Validation\Validator as BaseValidator;
use Simtabi\Laranail\Validation\Factory\RuleFactory;

final class Validator extends BaseValidator
{
    public function __call($method, $parameters)
    {
        try {

            $rule           = \mb_substr($method, 8);
            [$value, $args] = [$parameters[1], $parameters[2],];

            return RuleFactory::make($rule, $args)->validate($value);
        } catch (\Exception $e) {
            return parent::__call($method, $parameters);
        }
    }
}