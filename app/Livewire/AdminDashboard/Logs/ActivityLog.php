<?php

namespace App\Livewire\AdminDashboard\Logs;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Spatie\Activitylog\Models\Activity;

#[Layout('components.layouts.admin-dashboard')]
class ActivityLog extends Component
{
    use Toast, WithPagination;

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];
    public array $expanded = [];

    public function render()
    {
        $logs = Activity::orderBy(...array_values($this->sortBy))->paginate(15);


        return view('livewire.admin-dashboard.logs.activity-log',['logs'=>$logs])->title('Activity Logs');
    }
}
