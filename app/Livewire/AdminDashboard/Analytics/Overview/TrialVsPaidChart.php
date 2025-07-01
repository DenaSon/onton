<?php

namespace App\Livewire\AdminDashboard\Analytics\Overview;

use App\Models\Cashier\Subscription;
use Carbon\Carbon;
use Livewire\Component;

class TrialVsPaidChart extends Component
{
    public array $trialVsPaidChart = [];

    public function mount(): void
    {
        $months = [];
        $trialCounts = [];
        $paidCounts = [];

        // از 5 ماه پیش تا این ماه
        for ($i = 5; $i >= 0; $i--) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $label = $start->format('M Y'); // مثلا "Jan 2025"

            $months[] = $label;

            // Trial subscriptions
            $trial = Subscription::where('stripe_status', 'trialing')
                ->whereBetween('created_at', [$start, $end])
                ->distinct('user_id')
                ->count('user_id');

            // Paid subscriptions
            $paid = Subscription::where('stripe_status', 'active')
                ->whereBetween('created_at', [$start, $end])
                ->distinct('user_id')
                ->count('user_id');

            $trialCounts[] = $trial;
            $paidCounts[] = $paid;
        }

        $this->trialVsPaidChart = [
            'type' => 'bar',
            'data' => [
                'labels' => $months,
                'datasets' => [
                    [
                        'label' => 'Trial Users',
                        'data' => $trialCounts,
                        'backgroundColor' => 'rgba(251, 191, 36, 0.8)', // yellow-400
                        'stack' => 'users',
                    ],
                    [
                        'label' => 'Paid Users',
                        'data' => $paidCounts,
                        'backgroundColor' => 'rgba(34, 197, 94, 0.8)', // green-500
                        'stack' => 'users',
                    ],
                ],
            ],
            'options' => [
                'responsive' => true,
                'plugins' => [
                    'legend' => ['position' => 'top'],
                    'title' => [
                        'display' => true,
                        'text' => 'Trial vs Paid Subscriptions (Last 6 Months)',
                    ],
                ],
                'scales' => [
                    'x' => [
                        'stacked' => true,
                        'ticks' => ['autoSkip' => false],
                    ],
                    'y' => [
                        'stacked' => true,
                        'beginAtZero' => true,
                    ],
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin-dashboard.analytics.overview.trial-vs-paid-chart');
    }
}
