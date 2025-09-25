<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'address',
        'contact_person',
        'phone',
        'status',
        'url',
        'max_queue_time',
    ];

    protected $casts = [
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(TenantSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->latest('end_date')
            ->first();
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
