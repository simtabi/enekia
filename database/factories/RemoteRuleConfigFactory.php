<?php

namespace Simtabi\Enekia\Database\Factories;

use Simtabi\Enekia\Laravel\Models\RemoteRuleConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

class RemoteRuleConfigFactory extends Factory
{
    protected $model = RemoteRuleConfig::class;

    public function definition()
    {
        return [
            'name' => 'test',
            'url' => 'url',
            'method' => 'post',
            'headers' => null,
            'json' => null,
            'timeout' => null,
        ];
    }
}
