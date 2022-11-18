<?php

namespace Simtabi\Enekia\Laravel\Validators\Profanity;

use Illuminate\Support\Facades\Config;

class ProfanityDictionary
{

    private const BASE_PATH = __DIR__.'/../../../';

    /**
     * [$dictionary description].
     *
     * @var [type]
     */
    private $dictionary;

    /**
     * [__construct description].
     *
     * @param [type] $dictionary [description]
     */
    public function __construct($dictionary = null)
    {
        // Get default locale string in laravel project
        // and set it as default dictionary
        $locale = Config::has('app.locale') ? Config::get('app.locale') : 'en';

        $this->setDictionary($dictionary ?: $locale);
    }

    /**
     * [getDictionary description].
     *
     * @return [type] [description]
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * Set the dictionary to use.
     *
     * @param array|string $dictionary
     */
    public function setDictionary($dictionary)
    {
        $this->dictionary = $this->readDictionary($dictionary);
    }

    /**
     * [readDictionary description].
     *
     * @param [type] $dictionary [description]
     *
     * @return [type] [description]
     */
    protected function readDictionary($dictionary): array
    {
        $baseDictPath = $this->getBaseDictPath();
        $words        = [];

        if (is_array($dictionary)) {
            foreach ($dictionary as $file) {
                if (file_exists($baseDictPath.$file.'.php')) {
                    $dict  = include $baseDictPath.$file.'.php';
                    $words = array_merge($words, $dict);
                } else {
                    // if the file isn't in the dict directory,
                    // it's probably a custom user library
                    $dict  = include $file;
                    $words = array_merge($words, $dict);
                }
            }
            // just a single string, not an array
        } elseif (is_string($dictionary)) {
            if (file_exists($baseDictPath.$dictionary.'.php')) {
                $dict  = include $baseDictPath.$dictionary.'.php';
                $words = array_merge($words, $dict);
            } else {
                if (file_exists($dictionary)) {
                    $dict  = include $dictionary;
                    $words = array_merge($words, $dict);
                }  // else nothing is merged
            }
        }

        return $words;
    }

    /**
     * [getBaseDictPath description].
     *
     * @return [type] [description]
     */
    protected function getBaseDictPath(): string
    {
        return property_exists($this, 'baseDictPath') ? $this->baseDictPath : self::BASE_PATH.'resources/dictionaries/profanity/';
    }
}
