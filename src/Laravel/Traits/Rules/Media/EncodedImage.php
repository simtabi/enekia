<?php declare(strict_types = 1);

namespace Simtabi\Enekia\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;

class EncodedImage extends AbstractRule implements Rule
{

    /**
     * Pointer to the temporary file.
     *
     **/
    protected $file;


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
     * Write the given data to a temporary file.
     *
     **/
    protected function createTemporaryFile(string $data) : UploadedFile
    {
        $this->file = tmpfile();

        fwrite($this->file, base64_decode(Str::after($data, 'base64,')));

        return new UploadedFile(
            stream_get_meta_data($this->file)['uri'],
            'image',
            'text/plain',
            null,
            true,
            true
        );
    }



    /**
     * Determine if the validation rule passes.
     *
     * The rule requires at least a single parameter, which is
     * the expected mime types of the file e.g. png, jpeg etc.
     * You can also supply multiple mime types as an array.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $valid_mime = false;

        foreach ($this->parameters as $mime) {
            if (Str::startsWith($value, "data:image/$mime;base64,")) {
                $valid_mime = true;

                break;
            }
        }

        if ($valid_mime) {
            $result = validator(['file' => $this->createTemporaryFile($value)], ['file' => 'image'])->passes();

            fclose($this->file);

            return $result;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        $mimes = $this->parameters;

        if (count($mimes) === 1) {
            $data = $mimes[0];
        }else{
            $mimes[count($mimes) - 1] = 'or ' . $mimes[count($mimes) - 1];

            $data = implode(', ', $mimes);
        }

        return [
            'key'        => 'encoded_image',
            'parameters' => [
                'encoded_image' => $data,
            ],
        ];
    }
}
