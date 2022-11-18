<?php

namespace Simtabi\Enekia\Laravel\Abstracts;

use ReflectionClass;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Simtabi\Enekia\Laravel\Traits\HasCurrentLocale;

abstract class AbstractRule
{
    use HasCurrentLocale;

    private const PATH = __DIR__ . '/../../';

    /** @var string */
    protected string  $attribute;

    /** @var mixed */
    protected mixed   $value;

    /**
     * Array of supporting parameters.
     *
     **/
    protected array   $parameters;

    /**
     * Hold custom message
     * @var string|null $message
     */
    protected ?string $message;

    /**
     * @var string|null
     */
    protected ?string $messageKey = null;

    /** @var bool */
    protected bool    $required = true;

    public function __construct()
    {
        $this->parameters = func_get_args();
    }

    public function nullable(): self
    {
        $this->required = false;

        return $this;
    }

    /**
     * Return shortname of current rule
     *
     * @return string
     */
    protected function shortname(): string
    {
        return strtolower((new ReflectionClass($this))->getShortName());
    }

    /**
     * Set a custom validation error message.
     *
     * @param $message
     * @return static
     */
    public function setMessage($message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Return localized error message
     *
     * @return string
     */
    public function message()
    {

        if (isset($this->message) && !empty($this->message)){
            return $this->message;
        }else{

            $parameters = [];
            $transKey   = $this->shortname();

            if (method_exists($this, 'getMessageKey'))
            {
                $data = $this->getMessageKey();
                if (is_array($data)){
                    $transKey   = $data['key'];
                    $parameters = $data['parameters'];
                }else{
                    $transKey = $data;
                }
            }

            // try key for application custom translation
            $key = 'validation.' . $transKey;

            if (function_exists('trans'))
            {
                // if message is same as key, there is no
                // translation, so we will use internal
                $message = trans($key, $parameters);
                if ($message === $key) {
                    return trans('validation::' . $key, $parameters);
                }

                return $message;
            }

            return $this->translatorInstance()->get($key);
        }

    }

    protected function translatorInstance(): Translator
    {
        $loader = new FileLoader(new Filesystem(), self::PATH . 'resources/lang');

        return new Translator($loader, self::getCurrentLocale());
    }

    protected function grabRuleData(string $attribute, mixed $value): static
    {
        $this->attribute = $attribute;
        $this->value     = $value;

        return $this;
    }

}
