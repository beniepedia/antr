<?php

namespace App\Livewire\Tenant\Payment;

use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class PaymentVerify extends Component
{
    public $transaction = null;

    public $status = 'pending'; // pending, paid, failed

    #[Url('reference')]
    public $reference = null;

    public function mount()
    {
        $tenant = auth('tenant')->user()->tenant;
        $this->transaction = Transaction::where('payment_ref', $this->reference)
            ->where('tenant_id', $tenant->id)
            ->firstOrFail();
    }

    #[On('check-payment')]
    public function updateStatus()
    {
        if ($this->transaction->status !== 'pending') {
            $this->status = $this->transaction->status;
            $this->dispatch('payment-response');
        }
    }

    public function render()
    {
        return view('livewire.tenant.payment-verify')->layout('layouts.guest');
    }
}
