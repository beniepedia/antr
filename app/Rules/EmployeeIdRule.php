<?php

namespace App\Rules;

use App\Models\Profile;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class EmployeeIdRule implements ValidationRule
{
    protected ?int $ignoreProfileId;

    public function __construct(?int $ignoreProfileId = null)
    {
        $this->ignoreProfileId = $ignoreProfileId;
    }

    /**
     * Jalankan validasi employee_id unik per tenant.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tenantId = Auth::user('tenant')->tenant_id ?? null;

        $query = Profile::where('employee_id', $value)
            ->whereHas('user', fn ($q) => $q->where('tenant_id', $tenantId));

        // kalau update, exclude profile dirinya sendiri
        if ($this->ignoreProfileId) {
            $query->where('id', '<>', $this->ignoreProfileId);
        }

        if ($query->exists()) {
            $fail('ID karyawan sudah digunakan.');
        }
    }
}
