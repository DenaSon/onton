<?php

namespace App\Livewire\AdminDashboard\Analytics\Overview;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;
#[Layout('components.layouts.admin-dashboard')]

class AnalysisIndex extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard.analytics.overview.analysis-index')->title('Analysis Overview');
    }
}
