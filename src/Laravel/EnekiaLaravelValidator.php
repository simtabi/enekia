<?php

namespace Simtabi\Enekia\Laravel;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator as IlluminateValidator;
use Simtabi\Enekia\Exceptions\ValidationException;
use Simtabi\Enekia\Laravel\Traits\HasCurrentLocale;

class EnekiaLaravelValidator
{
    use HasCurrentLocale;

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
            throw new ValidationException('Failed asserting that value applies to rule "' . get_class($rule) . '".');
        }

        return $passes;
    }

    protected static function factory(): Factory
    {
        $loader     = new FileLoader(new Filesystem(), __DIR__ . '/../resources/lang');
        $translator = new Translator($loader, self::getCurrentLocale());
        $factory    = new Factory($translator, new Container());
        $factory->resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            return new IlluminateValidator($translator, $data, $rules, $messages, $customAttributes);
        });

        return $factory;
    }
}
