<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestDuitkuCallback extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'payment:callback 
        {--ref= : Reference dari Duitku (payment_ref)}
        {--id= : ID transaksi}
        {--email= : Email tenant untuk mencari transaksi pending}';

    /**
     * The console command description.
     */
    protected $description = 'Simulasi callback Duitku untuk testing dari CLI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = Transaction::query()->where('status', 'pending');

        if ($ref = $this->option('ref')) {
            $trx = $query->where('payment_ref', $ref)->first();
        } elseif ($id = $this->option('id')) {
            $trx = $query->where('id', $id)->first();
        } elseif ($email = $this->option('email')) {
            $trx = $query->whereHas('tenant', fn ($q) => $q->where('email', $email))->first();
        } else {
            $trx = $query->latest()->first();
        }

        if (!$trx) {
            $this->error('❌ Transaksi pending tidak ditemukan.');
            return Command::FAILURE;
        }

        $payload = [
            "merchantCode"     => config('duitku.merchant_code', 'DS25140'),
            "amount"           => $trx->total,
            "merchantOrderId"  => $trx->transaction_code,
            "productDetail"    => $trx->plan->name ?? 'Bulanan',
            "additionalParam"  => "",
            "paymentCode"      => $trx->payment_method ?? 'VC',
            "resultCode"       => "00",
            "merchantUserId"   => "TENANT" . $trx->tenant_id,
            "reference"        => $trx->payment_ref,
            "signature"        => md5(
                config('duitku.merchant_code') .
                $trx->total .
                $trx->transaction_code .
                config('duitku.api_key')
            ),
            "settlementDate"   => now()->format('Y-m-d H:i:s'),
        ];

        $url = route('tenant.payment.callback');

        $this->info("🚀 Mengirim simulasi callback ke: $url");
        $this->line(json_encode($payload, JSON_PRETTY_PRINT));

        try {
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $payload);

            $this->newLine();
            $this->info('✅ Response dari server:');
            $this->line($response->body());
        } catch (\Throwable $e) {
            $this->error("❌ Gagal mengirim callback: " . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
