<?php

namespace Simtabi\Enekia;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Support\Str;
use Simtabi\Enekia\Traits\HasCurrentLocale;

abstract class AbstractRule
{
    use HasCurrentLocale;

    /** @var ?string */
    protected ?string $messageKey = null;

    /** @var string */
    protected $attribute;

    /** @var mixed */
    protected $value;

    /**
     * @param string $attribute
     * @return self
     */
    public function setAttribute(string $attribute): self
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }


    /**
     * Return shortname of current rule
     *
     * @return string
     */
    protected function shortname(): string
    {
        return strtolower(Str::snake(class_basename(get_called_class())));
        // return strtolower((new ReflectionClass($this))->getShortName());
    }

    /**
     * Return localized error message
     *
     * @return string
     */
    public function message()
    {
        if (method_exists($this, 'customMessage')) {
            return $this->customMessage();
        }
        else{
            // try key for application custom translation
            $key = 'messages.' . $this->shortname();

            if (function_exists('trans')) {
                // if message is same as key, there is no
                // translation. we will use internal
                $message = trans($key);
                if ($message === $key) {
                    return trans('messages::' . $key);
                }

                return $message;
            }

            return $this->translatorInstance()->get($key);
        }

    }

    protected function translatorInstance(): Translator
    {
        $loader = new FileLoader(new Filesystem(), __DIR__ . '/lang');
        return new Translator($loader, self::getCurrentLocale());
    }

    /**
     * The regular expression matcher
     *
     * @param string $value
     * @param string $pattern
     * @return bool
     */
    protected function callPregMatcher($value, $pattern): bool
    {
        return preg_match($pattern, $value) === 1;
    }

    /**
     * The generic validation function which can check for multiple validators
     *
     * @param string[] $functionNames
     * @param mixed $value
     * @return bool
     */
    protected function checkValidationFnsFor(array $functionNames, mixed $value): bool
    {
        return array_reduce($functionNames, function ($accum, $fnName) use ($value) {
            return $accum || $this->{$fnName}($value);
        }, false);
    }
}