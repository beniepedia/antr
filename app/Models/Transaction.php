<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'coupon_id',
        'transaction_code',
        'payment_ref',
        'subtotal',
        'discount',
        'total',
        'status',
        'payment_method',
        'paid_at',
        'expires_at',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    // Buat kode transaksi unik
    public static function generateCode(): string
    {
        return strtoupper('INV-' . now()->format('Ymd') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT));
    }

    // Tandai transaksi sudah dibayar
    public function markAsPaid(array $meta = []): void
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
            'meta' => array_merge($this->meta ?? [], $meta),
        ]);
    }

    // Tandai transaksi gagal / expired
    public function markAsFailed(?string $reason = null): void
    {
        $meta = $this->meta ?? [];
        if ($reason) $meta['failure_reason'] = $reason;

        $this->update([
            'status' => 'failed',
            'meta' => $meta,
        ]);
    }

    // Periksa apakah sudah dibayar
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    // Periksa apakah masih bisa dibayar
    public function isPending(): bool
    {
        return $this->status === 'pending' && (!$this->expires_at || $this->expires_at->isFuture());
    }
}
