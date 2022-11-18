<?php

namespace Simtabi\Enekia\Laravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $hits
 * @property Carbon $last_queried
 */
class ValidatedDisposableDomain extends Model
{
    /**
     * @var string[]
     */
    protected $guarded = [];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'last_queried',
    ];

    /**
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('disposable.domain.checks_table'));
    }
}