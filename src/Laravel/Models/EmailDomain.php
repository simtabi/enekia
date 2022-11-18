<?php

namespace Simtabi\Enekia\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class EmailDomain extends Model
{

    protected $table    = 'enekia_email_domains';

    protected $fillable = [
        'domain',
    ];
}
