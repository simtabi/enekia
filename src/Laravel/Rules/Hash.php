<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

/**
 * The field under validation must be a hash of type algorithm. Algorithm is one of
 * ['md4', 'md5', 'sha1', 'sha256', 'sha384', 'sha512', 'ripemd128', 'ripemd160',
 * 'tiger128', 'tiger160', 'tiger192', 'crc32', 'crc32b']
 *
 * @package Simtabi\Enekia\Laravel\Rules
 */
class Hash extends AbstractRule implements Rule
{
    /**
     * @var string
     */
    private $algorithm;

    /**
     * @var string
     */
    private string $attribute;

    /**
     * Create a new rule instance.
     *
     * @param string $algorithm 'md4' | 'md5' | 'sha1' | 'sha256' | 'sha384' | 'sha512' | 'ripemd128' | 'ripemd160' | 'tiger128' | 'tiger160' | 'tiger192' | 'crc32' | 'crc32b'
     */
    public function __construct(string $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;

        try {
            $hash = '/^[a-fA-F0-9]{' . $this->getLength($this->algorithm) . '}$/';

            return preg_match($hash, $value);
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Get length.
     *
     * @param string $algorithm
     * @return int
     */
    private function getLength(string $algorithm): int
    {
        $lengths = [
            'md5'       => 32,
            'md4'       => 32,
            'sha1'      => 40,
            'sha256'    => 64,
            'sha384'    => 96,
            'sha512'    => 128,
            'ripemd128' => 32,
            'ripemd160' => 40,
            'tiger128'  => 32,
            'tiger160'  => 40,
            'tiger192'  => 48,
            'crc32'     => 8,
            'crc32b'    => 8,
        ];

        return $lengths[$algorithm];
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return [
            'key'        => 'hash',
            'parameters' => [
                'attribute' => $this->attribute,
                'algorithm' => $this->algorithm,
            ],
        ];
    }
}
