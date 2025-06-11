<?php

namespace App\Livewire\AdminDashboard\Analytics\Overview;

use Livewire\Attributes\Lazy;
use Livewire\Component;
class ActiveUserChart extends Component
{
    public array $activeUserChart = [
        'type' => 'line',
        'data' => [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'datasets' => [
                [
                    'label' => 'Active Users',
                    'data' => [50, 65, 70, 35, 95, 126],
                    'borderColor' => 'rgba(16, 185, 129, 1)', // emerald-500
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'New Subscriptions',
                    'data' => [10, 15, 25, 20, 15, 49],
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
                    'text' => 'Active Users & Subscriptions Trend',
                ],
            ],
            'scales' => [
                'y' => ['beginAtZero' => true],
            ],
        ],
    ];



    public function render()
    {
        return view('livewire.admin-dashboard.analytics.overview.active-user-chart');
    }
}
