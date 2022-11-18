<?php

namespace Maize\RemoteRule;

use Closure;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Simtabi\Enekia\Laravel\Abstracts\AbstractRule;
use Simtabi\Enekia\Laravel\Models\RemoteRuleConfig;

class RemoteRule extends AbstractRule implements Rule
{

    /**
     * Create a new rule instance.
     *
     */
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;
        $this->value     = $value;

        return $this->debug(
            fn () => $this->validate()
        );
    }

    protected function debug(Closure $callback): bool
    {
        try {
            return $callback();
        } catch (Exception $e) {
            if (config('enekia.remote_rule.debug')) {
                throw $e;
            }

            return false;
        }
    }

    protected function validate(): bool
    {
        $response = $this->send($this->findConfig());

        return $this->isSuccessful($response);
    }

    protected function findConfig(): RemoteRuleConfig|Model
    {
        /** @var RemoteRuleConfig $configModel */
        $configModel = app(config('enekia.remote_rule.config_model'));

        return $configModel::query()->where('name', $this->name())->sole();
    }

    protected function name(): string
    {
        return Str::snake(class_basename($this));
    }

    protected function send(RemoteRuleConfig $config): Response
    {
        return Http::send($config->method, $config->url, $this->getOptions($config));
    }

    protected function isSuccessful(Response $response): bool
    {
        return $response->ok();
    }

    protected function getOptions(RemoteRuleConfig $config): array
    {
        $options = array_merge(
            $this->getTimeout($config),
            $this->getHeaders($config),
            $this->getJson($config),
        );

        return Arr::where(
            $options,
            fn ($value) => ! empty($value)
        );
    }

    protected function getTimeout(RemoteRuleConfig $config): array
    {
        return [
            'timeout' => $config->timeout,
        ];
    }

    protected function getHeaders(RemoteRuleConfig $config): array
    {
        return [
            'headers' => Arr::wrap($config->headers),
        ];
    }

    protected function getJson(RemoteRuleConfig $config): array
    {
        return [
            'json' => array_merge(
                Arr::wrap($config->json),
                $this->getBodyAttribute()
            ),
        ];
    }

    protected function getBodyAttribute(): array
    {
        return [$this->attribute => $this->value];
    }

    /**
     * Get the validation error message.
     *
     **/
    public function getMessageKey(): string|null|array
    {
        return 'remote_rule';
    }

}
