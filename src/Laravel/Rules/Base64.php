<?php declare(strict_types=1);

namespace Simtabi\Enekia\Laravel\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Illuminate\Support\Str;

class Base64 extends AbstractRule implements Rule
{

    /**
     * @var bool
     */
    private bool $checkIfIsString = false;

    /**
     * @var bool
     */
    private bool $checkIfIsImage = false;

    /**
     * @var bool
     */
    private bool $checkIfIsMaxImageSize = false;

    /**
     * @var int
     */
    private int  $maxImageSize      = 2000000;

    private array $allowedMimeTypes = ['bmp', 'jpg', 'jpeg', 'png', 'gif', 'tiff'];


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->checkIfIsString){
            return base64_encode(base64_decode($value, true)) === $value;
        }elseif ($this->checkIfIsImage){

            $checkOne = function () use ($value){
                if (!Str::containsAll($value, ['data:image/', 'base64,'])) {
                    return false;
                }

                $base64Image = Str::after($value, ';base64,');

                try {
                    $rawData   = base64_decode($base64Image);
                    $mimeTypes = finfo_buffer(finfo_open(), $rawData, FILEINFO_MIME_TYPE);
                    $ext       = substr(strstr($mimeTypes, '/'), strlen('/'));

                    if (count($this->allowedMimeTypes) > 0 && !in_array($ext, $this->allowedMimeTypes)) {
                        return false;
                    }
                } catch (Exception $e) {
                    return false;
                }

                return true;
            };

            $checkTwo = function () use ($value){
                try {
                    if (strpos($value, ';base64') !== false) {
                        [, $value] = explode(';', $value);
                        [, $value] = explode(',', $value);
                    }

                    $tempFile = tempnam(sys_get_temp_dir(), 'temp');
                    file_put_contents($tempFile, base64_decode($value));

                    $validation = Validator::make(
                        ['file' => new File($tempFile)],
                        ['file' => 'image'],
                    );

                    return !$validation->fails();
                } catch (\Throwable $th) {
                    return false;
                }
            };

        return $checkOne() || $checkTwo;

        }elseif ($this->checkIfIsMaxImageSize){
            if (!Str::containsAll($value, ['data:image/', 'base64,'])) {
                return false;
            }

            // get the image size
            $size = (int) (strlen(rtrim($value, '=')) * 3 / 4);

            if ($size > $this->maxImageSize) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Validate a base64 string.
     *
     * @return static
     */
    public function checkIfIsString(): static
    {
        $this->checkIfIsString = true;

        return $this;
    }

    /**
     * Validate a base64 image string.
     * Pre-defined allowed image types are jpg, jpeg, png, gif, bmp and tiff.
     *
     * @param ...$allowedMimeTypes
     * @return static
     */
    public function checkIfIsImage(...$allowedMimeTypes): static
    {
        $this->checkIfIsImage = true;

        if (count($allowedMimeTypes) > 0)
        {
            $this->allowedMimeTypes = $allowedMimeTypes;
        }

        return $this;
    }

    /**
     * Validate a base64 image size. Default max size is 2 MB. Pass your own max size in byte (B).
     *
     * @param int $maxSize
     * @param ...$allowedMimeTypes
     * @return static
     */
    public function checkIfIsMaxImageSize(int $maxSize = 2000000, ...$allowedMimeTypes): static
    {
        $this->checkIfIsMaxImageSize = true;
        $this->maxImageSize          = $maxSize;

        if (count($allowedMimeTypes) > 0)
        {
            $this->allowedMimeTypes = $allowedMimeTypes;
        }

        return $this;
    }


    /**
     * Change bytes size to human-readable format.
     *
     * @param int $bytes
     * @return string
     */
    public static function bytesToHuman(int $bytes): string
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        for ($i = 0; $bytes > 1024; $i++)
        {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        if ($this->checkIfIsString){
            return 'base64.string';
        }elseif ($this->checkIfIsImage){
            return 'base64.image';
        }elseif ($this->checkIfIsMaxImageSize){
            return [
                'key'        => 'base64.max_size',
                'parameters' => [
                    'attribute' => $this->attribute,
                    'max_size'  => $this->bytesToHuman($this->maxImageSize),
                ],
            ];
        }

        return '';
    }

}
