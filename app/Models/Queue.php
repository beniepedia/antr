<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($query) {
            if (auth('customer')->check()) {
                $query->where('tenant_id', auth('customer')->user()->tenant_id);
            }
        });
    }

    protected $fillable = [
        'queue_number',
        'tenant_id',
        'customer_id',
        'customer_vehicle_id',
        'served_by',
        'liters_requested',
        'queue_date',
        'status',
        'checkin_time',
        'checkout_time',
    ];

    protected $casts = [
        'queue_date' => 'date',
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerVehicle()
    {
        return $this->belongsTo(CustomerVehicle::class);
    }

    public function vehicle()
    {
        // lewat customerVehicle -> vehicles
        return $this->hasOneThrough(Vehicle::class, CustomerVehicle::class, 'id', 'id', 'customer_vehicle_id', 'vehicle_id');
    }

    public function servedBy()
    {
        return $this->belongsTo(User::class, 'served_by');
    }

    public function getLicensePlateAttribute()
    {
        return $this->customerVehicle ? $this->customerVehicle->license_plate : null;
    }
}