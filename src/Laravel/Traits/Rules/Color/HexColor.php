<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Color;

trait HexColor
{
    /**
     * Allowed lengths of hexcolor
     *
     * @var array
     */
    protected array $lengths = [
        3,
        6,
    ];

    /**
     * @var bool
     */
    protected bool $checkHexColor = false;

    /**
     * @param int|null $length
     * @return static
     */
    public function checkHexColor(?int $length = null): static
    {
        $this->checkHexColor = true;

        if (is_int($length)) {
            $this->lengths = [$length];
        }

        return $this;
    }

    public function validateHexColor($attribute, $value): bool
    {
        if ((strlen($value) > 7) || ! in_array(strlen(trim($value, '#')), $this->lengths)) {
            return false;
        }

        $validate = function () use ($value) {
            $startsWithHashSign = str_starts_with($value, '#');
            $colourCodes        = explode('#', $value);

            $colours            = str_split(($startsWithHashSign) ? $colourCodes[1] : $value, 2);

            $validColourRange   = false;

            collect($colours)->each(static function ($colourCode) use (&$validColourRange) {
                if ((int) hexdec($colourCode) <= 255 || strlen($colourCode) <= 2) {
                    $validColourRange = true;
                }
            });

            return $validColourRange;
        };

        return $validate() || (bool) preg_match("/^#?([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $value);
    }

}
