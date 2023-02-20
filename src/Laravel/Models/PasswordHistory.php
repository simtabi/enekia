<?php

namespace Simtabi\Enekia\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Simtabi\Laranail\Traits\Models\Traits\UUID\HasUuid;

class PasswordHistory extends Model
{

    use HasUuid;

    /**
     * PasswordHistory constructor.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = config('enekia.password_history.table');

        parent::__construct($attributes);
    }

    protected $fillable = ['user_id', 'password'];
}
