<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Psr\SimpleCache\InvalidArgumentException;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\DisposableDomain;

abstract class AbstractDisposableHandler
{
    /**
     * The storage path to retrieve from and save to.
     *
     * @var string
     */
    protected string $storagePath;

    /**
     * Array of retrieved disposable domains.
     *
     * @var array
     */
    protected array $domains = [];

    /**
     * The cache repository.
     *
     * @var Cache|null
     */
    protected ?Cache $cache;

    /**
     * The cache key.
     *
     * @var string
     */
    protected string $cacheKey;

    /**
     * Disposable constructor.
     *
     * @param Cache|null $cache
     */
    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache;
    }

    /**
     * Loads the domains from cache/storage into the class.
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public function bootstrap(): static
    {
        $domains = $this->getFromCache();

        if (! $domains) {
            $this->saveToCache($domains = $this->getFromStorage());
        }

        $this->domains = $domains;

        return $this;
    }

    /**
     * Get the domains from cache.
     *
     * @return array|null
     * @throws InvalidArgumentException
     */
    protected function getFromCache(): ?array
    {
        if ($this->cache) {
            $domains = $this->cache->get($this->getCacheKey());

            // @TODO: Legacy code for bugfix. Remove me.
            if (is_string($domains) || empty($domains)) {
                $this->flushCache();
                return null;
            }

            return $domains;
        }

        return null;
    }

    /**
     * Save the domains in cache.
     *
     * @param  array|null  $domains
     */
    public function saveToCache(array $domains = null): void
    {
        if ($this->cache && ! empty($domains)) {
            $this->cache->forever($this->getCacheKey(), $domains);
        }
    }

    /**
     * Flushes the cache if applicable.
     */
    public function flushCache(): void
    {
        if ($this->cache) {
            $this->cache->forget($this->getCacheKey());
        }
    }

    abstract protected function getJsonFilePath(): string;

    /**
     * Get the domains from storage, or if non-existent, from the package.
     *
     * @return array
     */
    protected function getFromStorage(): array
    {
        if (File::isFile($this->getStoragePath())){
            $domains = file_get_contents($this->getStoragePath());
        }else{
            $domains = file_get_contents($this->getJsonFilePath());
        }

        return json_decode($domains, true);
    }

    /**
     * Save the domains in storage.
     *
     * @param array $domains
     * @return false|int
     */
    public function saveToStorage(array $domains): bool|int
    {
        $saved = file_put_contents($this->getStoragePath(), json_encode($domains));

        if ($saved) {
            $this->flushCache();
        }

        return $saved;
    }

    /**
     * Flushes the source's list if applicable.
     */
    public function flushStorage(): void
    {
        if (File::isFile($this->getStoragePath())) {
            File::delete($this->getStoragePath());
        }
    }

    /**
     * Checks whether the given email address' domain matches a disposable email service.
     *
     * @param string $email
     * @return bool
     */
    public function isDisposable(string $email): bool
    {
        if ($domain = Str::lower(Arr::get(explode('@', $email, 2), 1))) {
            return in_array($domain, $this->domains);
        }

        // Just ignore this validator if the value doesn't even resemble an email or domain.
        return false;
    }

    /**
     * Checks whether the given email address' domain doesn't match a disposable email service.
     *
     * @param string $email
     * @return bool
     */
    public function isNotDisposable(string $email): bool
    {
        return ! $this->isDisposable($email);
    }

    /**
     * Alias of "isNotDisposable".
     *
     * @param string $email
     * @return bool
     */
    public function isIndisposable(string $email): bool
    {
        return $this->isNotDisposable($email);
    }

    /**
     * Get the list of disposable domains.
     *
     * @return array
     */
    public function getDomains(): array
    {
        return $this->domains;
    }

    /**
     * Get the storage path.
     *
     * @return string
     */
    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    /**
     * Set the storage path.
     *
     * @param string $path
     * @return $this
     */
    public function setStoragePath(string $path): static
    {
        $this->storagePath = $path;

        return $this;
    }

    /**
     * Get the cache key.
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        return $this->cacheKey;
    }

    /**
     * Set the cache key.
     *
     * @param string $key
     * @return $this
     */
    public function setCacheKey(string $key): static
    {
        $this->cacheKey = $key;

        return $this;
    }
}