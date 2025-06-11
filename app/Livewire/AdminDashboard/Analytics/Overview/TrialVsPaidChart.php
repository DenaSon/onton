<?php

namespace App\Livewire\AdminDashboard\Analytics\Overview;

use Livewire\Attributes\Lazy;
use Livewire\Component;

class TrialVsPaidChart extends Component
{

    public array $trialVsPaidChart = [
        'type' => 'bar',
        'data' => [
            'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            'datasets' => [
                [
                    'label' => 'Trial Users',
                    'data' => [30, 25, 20, 18],
                    'backgroundColor' => 'rgba(251, 191, 36, 0.8)', // Tailwind yellow-400
                    'stack' => 'users',
                ],
                [
                    'label' => 'Paid Users',
                    'data' => [5, 10, 15, 20],
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)', // Tailwind green-500
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
                    'text' => 'Trial vs Paid Conversion (Weekly)',
                ],
            ],
            'scales' => [
                'x' => [
                    'stacked' => true,
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                ],
            ],
        ],
    ];




    public function render()
    {
        return view('livewire.admin-dashboard.analytics.overview.trial-vs-paid-chart');
    }
}
