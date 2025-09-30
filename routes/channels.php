<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tenant.{id}', function ($id) {
    return auth('tenant')->check() && auth('tenant')->id() === (int) $id;
});

Broadcast::channel('customer.{id}', function ($id) {
    return auth('customer')->check() && auth('customer')->id() === (int) $id;
});