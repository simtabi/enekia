<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\Domain\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Simtabi\Enekia\Laravel\Models\ValidatedDisposableDomain;
use stdClass;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;

class VerifyDomainFromMailcheckApi
{

    /**
     * @var int
     */
    public int $remaining = 0;

    /**
     * @var bool
     */
    public bool $fromCache;

    /**
     * @var bool
     */
    private bool $storeChecks;

    /**
     * @var bool
     */
    private bool $cacheChecks;

    /**
     * @var int
     */
    private int $cacheDuration;

    /**
     * @var string
     */
    private string $decisionRateLimit;

    /**
     * @var string
     */
    private string $decisionNoMx;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var string
     */
    private string $key;

    public function __construct()
    {

        $this->client = new Client([
            'base_uri' => 'https://www.mailcheck.ai/',
        ]);

        $this->storeChecks       = config('disposable.domain.store_checks');
        $this->cacheChecks       = config('disposable.domain.cache_checks');
        $this->cacheDuration     = config('disposable.domain.cache_duration');
        $this->decisionRateLimit = config('disposable.domain.decision_rate_limit');
        $this->decisionNoMx      = config('disposable.domain.decision_no_mx');
        $this->key               = config('disposable.domain.key');
    }

    /**
     * Query the API.
     *
     * @param string $domain
     *
     * @return stdClass API response data
     *@throws ClientException|GuzzleException
     *
     */
    private function query(string $domain): stdClass
    {
        $uri = '/domain/' . strtolower($domain);

        if ($this->key) {
            $uri .= '?key=' . $this->key;
        }

        $request = new Request('GET', $uri, [
            'Accept' => 'application/json',
        ]);

        try {
            $response = $this->client->send($request);
        } catch (RequestException $e) {
            return (object) [
                'status' => $e->getResponse()->getStatusCode(),
            ];
        }

        $data = json_decode($response->getBody());

        return (object) [
            'status'     => 200,
            'domain'     => $data->domain,
            'mx'         => optional($data)->mx ?? false,
            'disposable' => optional($data)->disposable ?? false,
        ];
    }

    private function storeResponse(stdClass $data): void
    {
        $this->remaining = $data->remaining_requests ?? 0;

        if ($this->storeChecks) {
            /** @var ValidatedDisposableDomain $check */
            $check = ValidatedDisposableDomain::query()->firstOrCreate(
                [
                    'domain'       => $data->domain,
                ],
                [
                    'mx'           => $data->mx,
                    'disposable'   => $data->disposable,
                    'last_queried' => Carbon::now(),
                ]
            );

            if ( ! $check->wasRecentlyCreated) {
                ++$check->hits;
                $check->last_queried = Carbon::now();

                $check->save();
            }
        }
    }

    /**
     * Decide whether the given data represents a valid domain.
     *
     * @param stdClass $data
     *
     * @return bool
     */
    private function decideIsValid(stdClass $data): bool
    {
        if ('deny' == $this->decisionNoMx && true !== optional($data)->mx) {
            return false;
        }

        return false === optional($data)->disposable;
    }

    /**
     * Check domain.
     *
     * @param string $domain
     *
     * @return bool
     * @throws GuzzleException
     */
    public function checkDomain(string $domain): bool
    {
        $cacheKey = __FUNCTION__.'_validator_mailcheck_' . $domain;
        $data     = null;

        // Retrieve from Cache if enabled

        if ($this->cacheChecks && Cache::has($cacheKey)) {
            $data = Cache::get($cacheKey);

            $this->fromCache = true;
        }

        if ( ! $this->fromCache) {
            $response = $this->query($domain);

            // The email address is invalid
            if (400 == $response->status) {
                return false;
            }

            // Rate limit exceeded
            if (429 == $response->status) {
                return 'allow' == $this->decisionRateLimit ? true : false;
            }

            if (200 != $response->status) {
                return false;
            }

            $data = $response;
        }

        // Store in Cache if enabled

        if ($this->cacheChecks && ! $this->fromCache) {
            Cache::put($cacheKey, $data, $this->cacheDuration);
        }

        // Store in Database or update Database query hits

        if ($this->storeChecks) {
            $this->storeResponse($data);
        }

        return $this->decideIsValid($data);
    }

    /**
     * Check email address.
     *
     * @param string $email
     *
     * @return bool
     * @throws GuzzleException
     */
    public function checkEmail(string $email): bool
    {
        if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        [$local, $domain] = explode('@', $email, 2);

        return $this->checkDomain($domain);
    }

}