<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Fetcher;

use InvalidArgumentException;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Contracts\DomainFetcher;
use UnexpectedValueException;

class DefaultDomainFetcher implements DomainFetcher
{
    public function handle($url): array
    {
        if (! $url) {
            throw new InvalidArgumentException('Source URL is null for disposable email');
        }

        $content = file_get_contents($url);

        if ($content === false) {
            throw new UnexpectedValueException('Failed to interpret the source URL ('.$url.') for disposable email');
        }

        if (! $this->isValidJson($content)) {
            throw new UnexpectedValueException('Provided data could not be parsed as JSON for disposable email');
        }

        return json_decode($content);
    }

    protected function isValidJson($data): bool
    {
        $data = json_decode($data, true);

        return json_last_error() === JSON_ERROR_NONE && ! empty($data);
    }
}