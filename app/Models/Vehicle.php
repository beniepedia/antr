<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth('customer')->check()) {
                $builder->where('tenant_id', auth('customer')->user()->tenant_id);
            } elseif (auth('tenant')->check()) {
                $builder->where('tenant_id', auth('tenant')->user()->tenant_id);
            }
        });
    }

    protected $fillable = [
        'tenant_id',
        'type',
        'max_liters',
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
