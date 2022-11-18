<?php

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class Url extends AbstractRule implements Rule
{
    /**
     * Define if we should use naive approach (true: starts_with)
     * or parse the url (false).
     *
     * @var bool
     */
    protected bool $checkSecureUrlNaively = false;
    protected bool $checkSecureUrl        = false;

    protected bool $checkImageUrl          = false;

    public function __construct()
    {

    }

    public function validateSecureUrl(bool $naively = false): static
    {
        $this->checkSecureUrlNaively = $naively;
        $this->checkSecureUrl        = true;

        return $this;
    }

    public function validateImageUrl(): static
    {
        $this->checkImageUrl = true;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes( $attribute, $value )
    {

        if (!is_string($value))
        {
            return false;
        }

        if ($this->checkSecureUrl){
            if ( $this->checkSecureUrlNaively )
            {
                return Str::startsWith( $value, 'https://' );
            }

            $parseUrl = function () use ($value) {
                $url = parse_url( $value );

                return ! empty( $url['scheme'] ) && $url['scheme'] === 'https';
            };

            return (preg_match('/^https:\/\/[a-z0-9-]{1,63}(\.[a-z0-9-]{1,63})+(\/\S*)?$/', $value) === 1) || $parseUrl();
        }elseif ($this->checkImageUrl){
            try {
                $tempFile = tempnam(sys_get_temp_dir(), 'temp');
                file_put_contents($tempFile, file_get_contents($value));

                $validation = Validator::make(
                    ['file' => new File($tempFile)],
                    ['file' => 'image'],
                );

                return !$validation->fails();
            } catch (\Throwable $th) {
                return false;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function getMessageKey(): string
    {
        if ($this->checkSecureUrl) {
            return 'url.secure';
        }elseif ($this->checkImageUrl){
            return 'url.image';
        }

        return '';
    }

}