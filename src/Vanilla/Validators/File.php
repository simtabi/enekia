<?php declare(strict_types=1);

namespace Simtabi\Enekia\Vanilla\Validators;

use Respect\Validation\Validator as Respect;
use Simtabi\Pheg\Toolbox\Media\File\FileSystem;

class File
{

    public function __construct(){}

    public function respect(): Respect
    {
        return new Respect();
    }

    /**
     * Checks if image has JPEG/JPG format
     *
     * @param string|null $format
     * @return bool
     */
    public function isJpeg(?string $format = null): bool
    {
        if (!$format) {
            return false;
        }

        $format = strtolower($format);
        return 'image/jpg' === $format || 'jpg' === $format || 'image/jpeg' === $format || 'jpeg' === $format;
    }

    /**
     * Checks if image has GIF format
     *
     * @param string|null $format
     * @return bool
     */
    public function isGif(?string $format = null): bool
    {
        if (!$format) {
            return false;
        }

        $format = strtolower($format);
        return 'image/gif' === $format || 'gif' === $format;
    }

    /**
     * Checks if image has PNG format
     *
     * @param string|null $format
     * @return bool
     */
    public function isPng(?string $format = null): bool
    {
        if (!$format) {
            return false;
        }

        $format = strtolower($format);
        return 'image/png' === $format || 'png' === $format;
    }

    /**
     * Checks if image has WEBP format
     *
     * @param string|null $format
     * @return bool
     */
    public function isWebp(?string $format = null): bool
    {
        if (!$format) {
            return false;
        }

        $format = strtolower($format);
        return 'image/webp' === $format || 'webp' === $format;
    }

    /**
     * Check is current path regular file
     *
     * @param string $path
     * @return bool
     */
    public function isFile(string $path): bool
    {
        $path = (new FileSystem())->clean($path);
        return file_exists($path) && is_file($path);
    }

    /**
     * @param mixed $variable
     * @return bool
     */
    public function isGdResource($variable): bool
    {
        return \is_resource($variable) && \strtolower(\get_resource_type($variable)) === 'gd';
    }

    /**
     * Check is format supported by lib
     *
     * @param string $format
     * @param array $formats
     * @return bool
     */
    public function isSupportedFormat(string $format, array $formats = []): bool
    {
        if ($format) {
            return $this->isJpeg($format) || $this->isPng($format) || $this->isGif($format) || $this->isWebp($format);
        }

        return false;
    }

    public function isEmptyDir($value): bool
    {
        if (!is_readable($value)) return false;

        $handle = opendir($value);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                return false;
            }
        }
        return true;
    }

}