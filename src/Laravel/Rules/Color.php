<?php

namespace Simtabi\Enekia\Laravel\Rules\Color;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Traits\Rules\Color\HexColor;
use Simtabi\Enekia\Laravel\Traits\Rules\Color\RgbaColor;
use Simtabi\Enekia\Laravel\Traits\Rules\Color\RgbColor;

class Color extends AbstractRule implements Rule
{

    use HexColor;
    use RgbColor;
    use RgbaColor;

    public function __construct()
    {
        $this->parameters = func_get_args();

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $this->grabRuleData($attribute, $value);

        if ($this->checkHexColor){
            return $this->validateHexColor($attribute, $value);
        }elseif ($this->checkRgbColor){
            return $this->validateRgbColor($attribute, $value);
        }elseif ($this->checkRgbaColor){
            return $this->validateRgbaColor($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkHexColor){
            return [
                'key'        => 'color.hex',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkRgbColor){
            return [
                'key'        => 'color.rgb',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkRgbaColor){
            return [
                'key'        => 'color.rgba',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }

        return '';
    }
}