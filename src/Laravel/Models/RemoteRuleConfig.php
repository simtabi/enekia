<?php

namespace Simtabi\Enekia\Laravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Simtabi\Enekia\Laravel\Models\Concerns\RemoteRuleCastsAttributes;

class RemoteRuleConfig extends Model
{
    use HasFactory;
    use RemoteRuleCastsAttributes;

    protected $table    = 'enekia_remote_rule_configs';

    protected $fillable = [
        'name',
        'url',
        'method',
        'headers',
        'json',
        'timeout',
    ];
}
