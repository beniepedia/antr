<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    protected $table = 'customer_vehicles';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
