<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'name',
        'whatsapp',
        'otp_code',
        'otp_expires_at',
        'last_otp_sent_at',
        'otp_attempts',
        'verified_at',
        'is_active',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'customer_vehicles')->withPivot(['id','license_plate'])->withTimestamps();
    }
}
