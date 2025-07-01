<?php

namespace App\Livewire\UserDashboard\Overview;

use App\Models\Vc;
use Livewire\Component;

class VcsWidget extends Component
{
    public $recentVCs;

    public function mount()
    {

        $this->recentVCs = Vc::query()
            ->withCount('newsletters')
            ->with('latestNewsletter')
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();
    }

    public function render()
    {
        return view('livewire.user-dashboard.overview.vcs-widget', [
            'recentVCs' => $this->recentVCs,
        ]);
    }
}
