<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $table = 'push_subscriptions';

    protected $fillable = [
        'endpoint',
        'public_key',
        'auth_token',
        'content_encoding',
        'tenant_id',
        'device_name',
        'last_used_at',
    ];

    public function subscribable()
    {
        return $this->morphTo();
    }
}
