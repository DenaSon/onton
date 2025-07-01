<?php
namespace App\Livewire\AdminDashboard\Analytics\Overview;

use App\Models\User;
use App\Models\Cashier\Subscription;
use Carbon\Carbon;
use Livewire\Component;

class ActiveUserChart extends Component
{
    public array $activeUserChart = [];

    public function mount(): void
    {
        $months = [];
        $allUsersCounts = [];
        $subscriptionsCounts = [];

        // آخرین 6 ماه
        for ($i = 5; $i >= 0; $i--) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $label = $start->format('M Y'); // مثلاً Jun 2025

            $months[] = $label;

            // تعداد کل کاربران ایجادشده در این ماه
            $userCount = User::whereBetween('created_at', [$start, $end])->count();

            // تعداد کاربران با اشتراک فعال شروع‌شده در این ماه
            $subscribedCount = Subscription::where('stripe_status', 'active')
                ->whereBetween('created_at', [$start, $end])
                ->distinct('user_id')
                ->count('user_id');

            $allUsersCounts[] = $userCount;
            $subscriptionsCounts[] = $subscribedCount;
        }

        $this->activeUserChart = [
            'type' => 'line',
            'data' => [
                'labels' => $months,
                'datasets' => [
                    [
                        'label' => 'All Users',
                        'data' => $allUsersCounts,
                        'borderColor' => 'rgba(16, 185, 129, 1)', // emerald-500
                        'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                        'fill' => true,
                        'tension' => 0.4,
                    ],
                    [
                        'label' => 'Subscriptions',
                        'data' => $subscriptionsCounts,
                        'borderColor' => 'rgba(59, 130, 246, 1)', // blue-500
                        'backgroundColor' => 'rgba(59, 130, 246, 0.15)',
                        'fill' => true,
                        'tension' => 0.4,
                    ],
                ],
            ],
            'options' => [
                'responsive' => true,
                'plugins' => [
                    'legend' => ['position' => 'top'],
                    'title' => [
                        'display' => true,
                        'text' => 'All Users & Subscriptions Trend (Last 6 Months)',
                    ],
                ],
                'scales' => [
                    'y' => ['beginAtZero' => true],
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin-dashboard.analytics.overview.active-user-chart');
    }
}
