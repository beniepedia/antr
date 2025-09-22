<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'queue_number',
        'tenant_id',
        'customer_id',
        'vehicle_id',
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

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function servedBy()
    {
        return $this->belongsTo(User::class, 'served_by');
    }
}