<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Simtabi\Enekia\Laravel\AbstractRule;

class Color  extends AbstractRule implements Rule
{

    /**
     * Supported color names
     *
     * @var string[]
     */
    protected const AVAILABLE_COLOR_NAMES       = [
        'silver',
        'gray',
        'white',
        'maroon',
        'red',
        'purple',
        'fuchsia',
        'green',
        'lime',
        'olive',
        'yellow',
        'navy',
        'blue',
        'teal',
        'aqua',
        'orange',
        'aliceblue',
        'antiquewhite',
        'aquamarine',
        'azure',
        'beige',
        'bisque',
        'blanchedalmond',
        'blueviolet',
        'brown',
        'burlywood',
        'cadetblue',
        'chartreuse',
        'chocolate',
        'coral',
        'cornflowerblue',
        'cornsilk',
        'crimson',
        'darkblue',
        'darkcyan',
        'darkgoldenrod',
        'darkgray',
        'darkgreen',
        'darkgrey',
        'darkkhaki',
        'darkmagenta',
        'darkolivegreen',
        'darkorange',
        'darkorchid',
        'darkred',
        'darksalmon',
        'darkseagreen',
        'darkslateblue',
        'darkslategray',
        'darkslategrey',
        'darkturquoise',
        'darkviolet',
        'deeppink',
        'deepskyblue',
        'dimgray',
        'dimgrey',
        'dodgerblue',
        'firebrick',
        'floralwhite',
        'forestgreen',
        'gainsboro',
        'ghostwhite',
        'gold',
        'goldenrod',
        'greenyellow',
        'grey',
        'honeydew',
        'hotpink',
        'indianred',
        'indigo',
        'ivory',
        'khaki',
        'lavender',
        'lavenderblush',
        'lawngreen',
        'lemonchiffon',
        'lightblue',
        'lightcoral',
        'lightcyan',
        'lightgoldenrodyellow',
        'lightgray',
        'lightgreen',
        'lightgrey',
        'lightpink',
        'lightsalmon',
        'lightseagreen',
        'lightskyblue',
        'lightslategray',
        'lightslategrey',
        'lightsteelblue',
        'lightyellow',
        'limegreen',
        'linen',
        'mediumaquamarine',
        'mediumblue',
        'mediumorchid',
        'mediumpurple',
        'mediumseagreen',
        'mediumslateblue',
        'mediumspringgreen',
        'mediumturquoise',
        'mediumvioletred',
        'midnightblue',
        'mintcream',
        'mistyrose',
        'moccasin',
        'navajowhite',
        'oldlace',
        'olivedrab',
        'orangered',
        'orchid',
        'palegoldenrod',
        'palegreen',
        'paleturquoise',
        'palevioletred',
        'papayawhip',
        'peachpuff',
        'peru',
        'pink',
        'plum',
        'powderblue',
        'rosybrown',
        'royalblue',
        'saddlebrown',
        'salmon',
        'sandybrown',
        'seagreen',
        'seashell',
        'sienna',
        'skyblue',
        'slateblue',
        'slategray',
        'slategrey',
        'snow',
        'springgreen',
        'steelblue',
        'tan',
        'thistle',
        'tomato',
        'turquoise',
        'violet',
        'wheat',
        'whitesmoke',
        'yellowgreen',
        'rebeccapurple',
        'black',
        'cyan',
        'magenta',
    ];

    /**
     * Special color names
     *
     * @var string[]
     */
    public const AVAILABLE_SPECIAL_COLOR_NAMES  = [
        'transparent',
    ];

    /**
     * Available validation rule names
     *
     * @var string[]
     */
    public const AVAILABLE_VALIDATION_RULES     = [
        'color',
        'color_hex',
        'color_rgb',
        'color_rgba',
        'color_name',
        'color_hsl',
        'color_hsla',
    ];

    /** @var bool */
    protected bool $includeHexPrefix = false;
    protected bool $withHexColor     = false;
    protected bool $withRGBColor     = false;
    protected bool $withRGBAColor    = false;
    protected bool $withColorName    = false;
    protected bool $withHSLColor     = false;
    protected bool $withHSLAColor    = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $this->setAttribute($attribute)->setValue(strtolower(trim($value)));

        // is valid hex code
        if ($this->withHexColor) {
            if (!$this->isValidHexColor($value)) {
                $this->messageKey = 'invalid_hex';
                return false;
            }
        }

        // is valid RGB color
        elseif ($this->withRGBColor) {
            if (!$this->isValidRGBColor($value)) {
                $this->messageKey = 'invalid_rgb';
                return false;
            }
        }

        // is valid RGBA color
        elseif ($this->withRGBAColor) {
            if (!$this->isValidRGBAColor($value)) {
                $this->messageKey = 'invalid_rgba';
                return false;
            }
        }

        // is valid color name
        elseif ($this->withColorName) {
            if (!$this->isValidColorName($value)) {
                $this->messageKey = 'invalid_name';
                return false;
            }
        }

        // is valid HSL color
        elseif ($this->withHSLColor) {
            if (!$this->isValidHSLColor($value)) {
                $this->messageKey = 'invalid_hsl';
                return false;
            }
        }

        // is valid HSLA color
        elseif ($this->withHSLAColor) {
            if (!$this->isValidHSLAColor($value)) {
                $this->messageKey = 'invalid_hsla';
                return false;
            }
        }

        // is valid color
        elseif (!$this->isValidColor()) {
            $this->messageKey = 'invalid';
            return false;
        }

        return true;
    }

    /**
     * The standard color validator (hex, rgb, rgba)
     *
     * @return bool
     */
    public function isValidColor(): bool
    {
        return $this->checkValidationFnsFor([
            'isValidHexColor',
            'isValidRGBColor',
            'isValidRGBAColor',
            'isValidColorName',
            'isValidHSLColor',
            'isValidHSLAColor',
        ], $this->value);
    }

    /**
     * The hex color validator
     * To check if a color is valid (long hex) or (short hex) color code
     *
     * @param $value
     * @return bool
     */
    public function isValidHexColor($value): bool
    {
        if ($this->includeHexPrefix && ! Str::startsWith($value, '#')) {
            $this->messageKey = 'prefixed_hexcode';
            return false;
        }

        return $this->callPregMatcher($value, '/^#?([\d|a|b|c|d|e|f]{3}|[\d|a|b|c|d|e|f]{6}|[a-fA-F0-9]{6}[0-9]{2})$/i');
    }

    /**
     * The RGB color validator
     *
     * @param $value
     * @return bool
     */
    public function isValidRGBColor($value): bool
    {
        return $this->callPregMatcher($value, '/^(rgb)\(([01]?\d\d?|2[0-4]\d|25[0-5])(\W+)([01]?\d\d?|2[0-4]\d|25[0-5])\W+(([01]?\d\d?|2[0-4]\d|25[0-5])\))$/i');
    }

    /**
     * The RGBA color validator
     *
     * @param $value
     * @return bool
     */
    public function isValidRGBAColor($value): bool
    {
        return $this->callPregMatcher($value, '/^(rgba)\(([01]?\d\d?|2[0-4]\d|25[0-5])\W+([01]?\d\d?|2[0-4]\d|25[0-5])\W+([01]?\d\d?|2[0-4]\d|25[0-5])\)?\W+([01](\.\d+)?)\)$/i');
    }

    /**
     * The color name validator
     *
     * @param $value
     * @return bool
     */
    public function isValidColorName($value): bool
    {
        return in_array(Str::lower($value), self::AVAILABLE_COLOR_NAMES, true)
            || in_array(Str::lower($value), self::AVAILABLE_SPECIAL_COLOR_NAMES, true);
    }

    /**
     * The HSL color validator
     *
     * @param $value
     * @return bool
     */
    public function isValidHSLColor($value): bool
    {
        return $this->callPregMatcher($value, '/^(hsl\((?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-9][0-9]|3[0-5][0-9]|360),(?:\s|)(?:[0-9]|[1-9][0-9]|100)%),(?:\s|)(?:[0-9]|[1-9][0-9]|100)%\)$/i');
    }

    /**
     * The HSLA color validator
     *
     * @param $value
     * @return bool
     */
    public function isValidHSLAColor($value): bool
    {
        return $this->callPregMatcher($value, '/^^(hsla\((?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-9][0-9]|3[0-5][0-9]|360),(?:\s|)(?:[0-9]|[1-9][0-9]|100)%),(?:\s|)(?:[0-9]|[1-9][0-9]|100)%,(?:\s|)(0|1|1\.0{1,}|0\.[0-9]{1,})\)$/i');
    }


    public function withHexPrefix(bool $status = true): self
    {
        $this->includeHexPrefix = $status;

        return $this;
    }

    public function withHexColor(bool $status = true): self
    {
        $this->withHexColor = $status;

        return $this;
    }

    public function withRGBColor(bool $status = true): self
    {
        $this->withRGBColor = $status;

        return $this;
    }

    public function withRGBAColor(bool $status = true): self
    {
        $this->withRGBAColor = $status;

        return $this;
    }

    public function withColorName(bool $status = true): self
    {
        $this->withColorName = $status;

        return $this;
    }

    public function withHSLColor(bool $status = true): self
    {
        $this->withHSLColor = $status;

        return $this;
    }

    public function withHSLAColor(bool $status = true): self
    {
        $this->withHSLAColor = $status;

        return $this;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function customMessage(): string
    {
        $key = $this->messageKey;
        if (!empty($key)) {
            return __("enekia::messages.$this->attribute.$key", [
                'attribute' => $this->attribute,
            ]);
        }
        return '';
    }

}
