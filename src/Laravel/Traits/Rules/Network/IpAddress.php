<?php

namespace Simtabi\Enekia\Laravel\Traits\Rules\Network;

use Exception;
use Simtabi\Enekia\Vanilla\Validators\IpAddress as IpAddressHelper;

trait IpAddress
{

    use IPv4;
    use IPv6;

    /**
     * @var bool
     */
    private bool $checkIfIsPrivate = false;

    /**
     * @var bool
     */
    private bool $checkIfIsPublic  = false;


    public function checkIfIsPrivate(): static
    {
        $this->checkIfIsPrivate = true;

        return $this;
    }

    public function checkIfIsPublic(): static
    {
        $this->checkIfIsPublic = true;

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
        if ($this->checkIfIsPrivate) {
            $this->messageKey = 'private';
            return (new IpAddressHelper($value))->isPrivate();
        }elseif ($this->checkIfIsPublic){
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