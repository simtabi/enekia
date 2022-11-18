<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Respect\Validation\Validator as Respect;

class Url
{

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    public function isUrl($value): bool
    {
        return $this->respect()->url()->validate($value);
    }

    /**
     * Checks to see if the page is being server over SSL or not
     *
     * @param bool $trustProxyHeaders
     * @return bool
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function isHttps(bool $trustProxyHeaders = false): bool
    {
        // Check standard HTTPS header
        if (array_key_exists('HTTPS', $_SERVER)) {
            return !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        }

        if ($trustProxyHeaders && array_key_exists('X-FORWARDED-PROTO', $_SERVER)) {
            return $_SERVER['X-FORWARDED-PROTO'] === 'https';
        }

        // Default is not SSL
        return false;
    }

    /**
     * Is absolute url
     *
     * @param string $path
     * @return bool
     */
    public function isAbsolute(string $path): bool
    {
        return strpos($path, '//') === 0 || preg_match('#^[a-z-]{3,}:\/\/#i', $path);
    }



}
