<?php

namespace Simtabi\Enekia;

use ReflectionClass;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use function __;
use function class_basename;
use function get_called_class;
use Simtabi\Enekia\Traits\HasCurrentLocale;

abstract class AbstractRule
{
    use HasCurrentLocale;

    /** @var ?string */
    protected ?string $messageKey = null;

    /** @var string */
    protected $attribute;

    /**
     * @param  string  $attribute
     */
    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * Return shortname of current rule
     *
     * @return string
     */
    protected function shortname(): string
    {
        return strtolower(Str::snake(class_basename(get_called_class())));
        return strtolower((new ReflectionClass($this))->getShortName());
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

}