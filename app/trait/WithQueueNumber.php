<?php

namespace App\trait;

use App\Models\Queue;

trait WithQueueNumber
{
    public static function generate(int $digit=4):string
    {
        $today = now()->toDateString();
        $tenant = app('tenant');

        $lastNumber = Queue::where('queue_date', $today)
            ->where('tenant_id', $tenant->id) // filter tenant biar tidak campur
            ->max('queue_number');

        $newNumber = str_pad(($lastNumber + 1), $digit, '0', STR_PAD_LEFT);

        return $newNumber;
    }
}
