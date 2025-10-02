<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pump extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
    ];
}
