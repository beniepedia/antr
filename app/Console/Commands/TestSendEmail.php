<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestSendEmail extends Command
{
    protected $signature = 'test:email {to}';
    protected $description = 'Kirim email percobaan untuk test konfigurasi mailer';

    public function handle(): void
    {
        $to = $this->argument('to');

        Mail::raw('Tes kirim email dari Laravel', function ($message) use ($to) {
            $message->to($to)->subject('Tes Email Laravel');
        });

        $this->info("✅ Email berhasil dikirim ke {$to}");
    }
}
