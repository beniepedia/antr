<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'max_uses',
        'used_count',
        'per_user_limit',
        'start_date',
        'end_date',
        'plan_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Kupon aktif (berdasarkan tanggal & status)
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah kupon valid untuk plan tertentu
     */
    public function isValidFor(Plan $plan): bool
    {
        // Status aktif
        if (!$this->is_active) {
            return false;
        }

        // Tanggal mulai & berakhir
        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        // Batas penggunaan
        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        // Jika hanya berlaku untuk plan tertentu
        if ($this->plan_id && $this->plan_id !== $plan->id) {
            return false;
        }

        return true;
    }

    /**
     * Hitung potongan harga berdasarkan plan
     */
    public function calculateDiscount(Plan $plan): float
    {
        if ($this->discount_type === 'percent') {
            $amount = $plan->price * ($this->discount_value / 100);
        } else {
            $amount = $this->discount_value;
        }

        // Pastikan tidak lebih dari harga plan
        return min($amount, $plan->price);
    }

    /**
     * Tandai kupon sudah dipakai
     */
    public function markUsed(): void
    {
        $this->increment('used_count');
    }
}
