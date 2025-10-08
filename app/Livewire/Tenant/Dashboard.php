<?php

namespace App\Livewire\Tenant;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function redirectToUpgrade()
    {
        return redirect()->route('tenant.upgrade');
    }

    public function render()
    {
        $user = Auth::guard('tenant')->user();
        $tenant = $user->tenant;

        // Dashboard data for tenant users
        $totalQueues = $tenant->queues()->count();
        $activeQueues = $tenant->queues()->whereIn('status', ['waiting', 'called'])->count();
        $totalCustomers = $tenant->customers()->count();

        $recentQueues = $tenant->queues()
            ->with(['customer', 'vehicle'])
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($queue) {
                return [
                    'id' => 'ANTRIAN' . str_pad($queue->queue_number, 3, '0', STR_PAD_LEFT),
                    'service' => $queue->vehicle->type ?? 'Unknown',
                    'date' => $queue->queue_date->format('d M Y'),
                    'status' => match ($queue->status) {
                        'waiting' => 'Menunggu',
                        'called' => 'Dipanggil',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        'expired' => 'Kadaluarsa',
                        default => 'Unknown'
                    },
                    'time' => $queue->checkin_time ? $queue->checkin_time->format('H:i') : '-',
                ];
            });

        $popularServices = $tenant->queues()
            ->join('customer_vehicles', 'queues.customer_vehicle_id', '=', 'customer_vehicles.id')
            ->join('vehicles', 'customer_vehicles.vehicle_id', '=', 'vehicles.id')
            ->selectRaw('vehicles.type, COUNT(*) as count')
            ->groupBy('vehicles.type')
            ->orderBy('count', 'desc')
            ->limit(4)
            ->pluck('type')
            ->toArray();

        $queueStatus = [
            'total' => $totalQueues,
            'completed' => $tenant->queues()->where('status', 'completed')->count(),
            'in_progress' => $tenant->queues()->where('status', 'called')->count(),
            'waiting' => $tenant->queues()->where('status', 'waiting')->count(),
            'delayed' => 0, // Assuming no delayed status, or add if needed
            'cancelled' => $tenant->queues()->where('status', 'cancelled')->count(),
        ];

        $subscription = $tenant->activeSubscription();
        $subscriptionData = null;
        if ($subscription) {
            $totalDays = $subscription->start_date->diffInDays($subscription->end_date);
            $daysRemaining = now()->diffInDays($subscription->end_date, false);
            $subscriptionData = [
                'plan_name' => $subscription->plan->name ?? 'Unknown',
                'status' => $subscription->status,
                'start_date' => indo_date($subscription->start_date, "DD MMM Y"),
                'end_date' => indo_date($subscription->end_date, "DD MMM Y"),
                'days_remaining' => $daysRemaining,
                'total_days' => $totalDays,
            ];
        }

        $plans = \App\Models\Plan::all(); // Assuming Plan model exists

        $dashboardData = [
            'total_queues' => $totalQueues,
            'active_queues' => $activeQueues,
            'total_users' => $totalCustomers,
            'recent_queues' => $recentQueues,
            'popular_services' => $popularServices,
            'queue_status' => $queueStatus,
            'subscription' => $subscriptionData,
            'plans' => $plans,
        ];

        return view('livewire.tenant.dashboard.index', compact('user', 'dashboardData'));
    }
}
