<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class QueuedVerifyEmail extends BaseVerifyEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Jumlah maksimum percobaan.
     */
    public $tries = 3;
    public $connection = 'database';
    public $delay = null;
    public $queue = 'emails';

  
    /**
     * Waktu delay antar percobaan (detik).
     */
    public $backoff = [10, 30, 60]; // retry ke-1: 10s, ke-2: 30s, ke-3: 60s

    public function __construct()
    {
        $this->connection = config('queue.default');
    }


    /**
     * Tangani error kalau job gagal dikirim.
     */
    public function failed(\Throwable $exception)
    {
        $notifiable = $this->notifiable ?? null;
        $email = $notifiable?->email ?? '(unknown)';
        Log::error('Gagal mengirim email verifikasi ke: ' . $email ?? '(unknown)', [
            'error' => $exception->getMessage(),
        ]);
    }
}
