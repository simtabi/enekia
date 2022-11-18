<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class FileExists extends AbstractRule implements Rule
{

    /**
     * Array of supporting parameters.
     *
     **/
    protected array $parameters;

    /**
     * Constructor.
     *
     **/
    public function __construct()
    {
        $this->parameters = func_get_args();
    }

    /**
     * Determine if the validation rule passes.
     *
     * The rule has two parameters:
     * 1. The disk defined in your config file.
     * 2. The directory to search within.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $path = rtrim($this->parameters[1] ?? '', '/');
        $file = ltrim($value, '/');

        return Storage::disk($this->parameters[0])->exists("$path/$file");
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return 'file_exists';
    }
}
