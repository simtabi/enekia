<?php

namespace Simtabi\Enekia\Laravel\Validators\CreditCards\Traits;

use Carbon\Carbon;
use Simtabi\Enekia\Laravel\Validators\CreditCards\Supports\ExpirationDateValidator;

trait CardExpirationDate
{

    /**
     * Date field format.
     *
     * @var string
     */
    protected string $format;

    /**
     * @var bool
     */
    protected bool $checkCardExpirationDate = false;

    public function checkCardExpirationDate(string $format): static
    {
        $this->checkCardExpirationDate = true;
        $this->format                  = $format;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateCardExpirationDate($attribute, $value): bool
    {
        try {

            // This can throw Invalid Date Exception if format is not supported.
            Carbon::parse($value);

            $date = Carbon::createFromFormat($this->format, $value);

            if (!(new ExpirationDateValidator($date->year, $date->month))->isValid()){
                $this->messageKey = static::MSG_CARD_EXPIRATION_DATE_INVALID;
                return false;
            }

            return true;

        } catch (\InvalidArgumentException $ex) {
            $this->messageKey = static::MSG_CARD_EXPIRATION_DATE_FORMAT_INVALID;

            return false;
        } catch (\Exception $ex) {
            $this->messageKey = static::MSG_CARD_EXPIRATION_DATE_INVALID;

            return false;
        }
    }

}
