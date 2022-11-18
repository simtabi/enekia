<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Validators\Respect;

use ReflectionClass;
use ReflectionException;
use Respect\Validation\Validatable;

final class RespectValidationRuleFactory
{
    /**
     * @throws ReflectionException
     */
    public static function make(string $rule, array $parameters = []): Validatable
    {
        $alias = [
            'FileExists' => 'Exists',
            'Arr'        => 'ArrayVal',
            'Bool'       => 'BoolType',
            'False'      => 'FalseVal',
            'Float'      => 'FloatVal',
            'Int'        => 'IntVal',
            'NullValue'  => 'NullType',
            'Object'     => 'ObjectType',
            'String'     => 'StringType',
            'True'       => 'TrueVal',
        ];

        /** @var Validatable $instance */
        $instance = (
        new ReflectionClass('Respect\\Validation\\Rules\\'.($alias[$rule] ?? $rule),)
        )->newInstanceArgs($parameters);

        return $instance;
    }
}