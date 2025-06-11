<?php

namespace App\Livewire\AdminDashboard\Overview;

use App\Services\HealthService;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;



class HealthWidget extends Component
{
    public function render()
    {

        $activities = Activity::latest()->take(10)->get();

        $health = \App\Services\HealthService::all();

        return view('livewire.admin-dashboard.overview.health-widget', ['activities' => $activities, 'health' => $health]);
    }
}
