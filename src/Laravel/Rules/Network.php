<?php

namespace Simtabi\Enekia\Laravel\Rules\Network;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Vanilla\Validators\IpAddress as IpAddressHelper;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\CidrNumber;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\DomainName;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\Hostname;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\IpAddress;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\IPv4;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\IPv6;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\MacAddress;
use Simtabi\Enekia\Laravel\Traits\Rules\Network\Subdomain;

class Network extends AbstractRule implements Rule
{

    use CidrNumber;
    use DomainName;
    use Hostname;
    use IpAddress;
    use IPv4;
    use IPv6;
    use MacAddress;
    use Subdomain;

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

        if ($this->checkIfIsDomainName){
            return $this->validateDomainName($attribute, $value);
        }elseif ($this->checkIPv4){
            return $this->validateIPv4($attribute, $value);
        }elseif ($this->checkIPv6){
            return $this->validateIPv6($attribute, $value);
        }elseif ($this->checkIfIsPrivate) {
            return (new IpAddressHelper($value))->isPrivate();
        }elseif ($this->checkIfIsPublic){
            return (new IpAddressHelper($value))->isPublic();
        }elseif ($this->checkMacAddress){
            return $this->validateMacAddress($attribute, $value);
        }elseif ($this->checkSubdomain){
            return $this->validateSubdomain($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkIfIsDomainName){
            return [
                'key'        => 'network.domain_name',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkIPv4){
            return [
                'key'        => 'network.ip_address.ipv4',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkIPv6){
            return [
                'key'        => 'network.ip_address.ipv6',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkMacAddress){
            return [
                'key'        => 'network.mac_address',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkSubdomain){
            return [
                'key'        => 'network.mac_address',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkIfIsPrivate){
            return [
                'key'        => 'network.ip_address.private',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkIfIsPublic){
            return [
                'key'        => 'network.ip_address.public',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }elseif ($this->checkIfIsPublic){
            return [
                'key'        => 'network.cidr_number',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                ],
            ];
        }

        return 'network.ip_address.not_valid';
    }
}
