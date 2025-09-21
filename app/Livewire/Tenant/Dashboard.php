<?php

namespace App\Livewire\Tenant;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::guard('tenant')->user();

        // Dashboard data for tenant users
        $dashboardData = [
            'total_queues' => 8,
            'active_queues' => 3,
            'total_users' => 156,
            'recent_queues' => [
                [
                    'id' => 'ANTRIAN001',
                    'service' => 'Pembuatan KTP',
                    'date' => '15 Mei 2025',
                    'status' => 'Selesai',
                    'time' => '10:30 AM'
                ],
                [
                    'id' => 'ANTRIAN002',
                    'service' => 'Pembuatan SIM',
                    'date' => '16 Mei 2025',
                    'status' => 'Dalam Proses',
                    'time' => '14:00 PM'
                ],
                [
                    'id' => 'ANTRIAN003',
                    'service' => 'Paspor',
                    'date' => '17 Mei 2025',
                    'status' => 'Dibatalkan',
                    'time' => '09:00 AM'
                ],
                [
                    'id' => 'ANTRIAN004',
                    'service' => 'Surat Nikah',
                    'date' => '18 Mei 2025',
                    'status' => 'Selesai',
                    'time' => '11:00 AM'
                ]
            ],
            'popular_services' => [
                'Pembuatan KTP',
                'Pembuatan SIM',
                'Paspor',
                'Surat Nikah'
            ],
            'queue_status' => [
                'total' => 156,
                'completed' => 42,
                'in_progress' => 28,
                'waiting' => 56,
                'delayed' => 12,
                'cancelled' => 18
            ]
        ];
        return view('livewire.tenant.dashboard.index', compact('user', 'dashboardData'))->layout('layouts.tenant');
    }
}
