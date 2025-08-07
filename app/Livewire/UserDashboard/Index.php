<?php

namespace App\Livewire\UserDashboard;

use App\Models\Newsletter;
use App\Models\Vc;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Layout('components.layouts.user-dashboard')]
#[Title('User Dashboard')]
class Index extends Component
{
    public int $newslettersToday = 0;
    public int $totalVCs = 0;
    public int $followedVCs = 0;

    public bool $showTrialAlert = false;
    public ?string $trialMessage = null;

    public function mount(): void
    {
        $user = auth()->user();

        $this->newslettersToday = Newsletter::whereDate('received_at', today())->count();
        $this->totalVCs = Vc::count();
        $this->followedVCs = $user?->followedVCs()->count() ?? 0;


        $subscription = $user?->subscription('default');


        if (!$subscription || is_null($subscription->trial_ends_at)) {
            $this->showTrialAlert = true;
            $this->trialMessage = "Start your free trial now!";
        }
    }





    public function render()
    {

        return view('livewire.user-dashboard.index');
    }
}
