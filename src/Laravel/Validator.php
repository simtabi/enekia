<?php

namespace Simtabi\Enekia\Laravel;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator as IlluminateValidator;
use Simtabi\Enekia\Laravel\Exceptions\EnekiaException;

class Validator
{
    use Traits\HasCurrentLocale;

    private const PATH = __DIR__ . '/../';

    public static function make(array $data, array $rules): IlluminateValidator
    {
        return self::factory()->make($data, $rules);
    }

    /**
     * Magic method for static calls, to call single rules directly
     *
     * @param  string $name
     * @param  array  $arguments
     * @return boolean
     */
    public static function __callStatic(string $name, array $arguments): bool
    {
        $delegation = new CallDelegator($name, $arguments);
        $rule       = $delegation->getRule();
        $passes     = self::make(['value' => $delegation->getValue()], ['value' => ['required', $rule]])->passes();

        if ($delegation->isAssertion() && $passes === false) {
            throw new EnekiaException('Failed asserting that value applies to rule "' . get_class($rule) . '".');
        }

        return $passes;
    }

    protected static function factory(): Factory
    {
        $loader     = new FileLoader(new Filesystem(), self::PATH . 'resources/lang');
        $translator = new Translator($loader, self::getCurrentLocale());
        $factory    = new Factory($translator, new Container());
        $factory->resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            return new IlluminateValidator($translator, $data, $rules, $messages, $customAttributes);
        });

        return $factory;
    }

    public static function getRuleShortnames(): array
    {
        return array_map(function ($filename) {
            return mb_strtolower(substr($filename, 0, -4));
        }, array_diff(scandir(__DIR__ . '/Rules'), ['.', '..']));
    }
}
