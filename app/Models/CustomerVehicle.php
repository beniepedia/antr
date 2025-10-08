<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
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
        'customer_id',
        'vehicle_id',
        'license_plate',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
