<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
