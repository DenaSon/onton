<?php

namespace App\Livewire\UserDashboard;

use App\Models\Newsletter;
use App\Models\Vc;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('components.layouts.user-dashboard')]
class Index extends Component
{
    public int $newslettersToday = 0;
    public int $totalVCs = 0;
    public int $followedVCs = 0;

    public function mount(): void
    {
        $user = auth()->user();

        $this->newslettersToday = Newsletter::whereDate('received_at', today())->count();

        $this->totalVCs = Vc::count();

        $this->followedVCs = $user ? $user->followedVCs()->count() : 0;
    }

    public function render()
    {
        return view('livewire.user-dashboard.index');
    }
}
