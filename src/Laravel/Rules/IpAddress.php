<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\AbstractRule;
use Simtabi\Enekia\Laravel\Helpers\IpAddress as IpAddressHelper;
use Exception;

class IpAddress extends AbstractRule implements Rule
{

    private bool $private = false;
    private bool $public  = false;


    public function byPrivate(): self
    {
        $this->private = true;
        return $this;
    }

    public function byPublic(): self
    {
        $this->public = true;
        return $this;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     * @throws Exception
     */
    public function passes($attribute, $value)
    {
        if ($this->private) {
            $this->messageKey = 'private';
            return (new IpAddressHelper($value))->isPrivate();
        }elseif ($this->public){
            $this->messageKey = 'public';
            return (new IpAddressHelper($value))->isPublic();
        }

        throw new Exception("You must specify the type of IP address to validate");
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
            return __("ekenia::messages.ip_address.$key", [
                'attribute' => $this->attribute,
            ]);
        }
        return '';
    }

}