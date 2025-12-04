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

    // NEW: last week stats
    public int $emailNewslettersLastWeek = 0;
    public int $substackNewslettersLastWeek = 0;
    public int $mediumUpdatesLastWeek = 0;

    public bool $showTrialAlert = false;
    public ?string $trialMessage = null;

    public function mount(): void
    {
        $user = auth()->user();

        // Today stats
        $this->newslettersToday = Newsletter::whereDate('received_at', today())->count();
        $this->totalVCs = Vc::count();
        $this->followedVCs = $user?->followedVCs()->count() ?? 0;

        // Last week stats (ALL newsletters, not only followed VCs)
        $oneWeekAgo = now()->subWeek();

        $baseQuery = Newsletter::query()
            ->where('received_at', '>=', $oneWeekAgo);


        $this->emailNewslettersLastWeek = (clone $baseQuery)
            //->where('source', 'email')
            ->count();

        $this->substackNewslettersLastWeek =

            Newsletter::query()
                ->where('received_at', '>=', $oneWeekAgo)
                ->whereRaw("SUBSTRING_INDEX(from_email, '@', -1) = 'substack.com'")->count();


        $this->mediumUpdatesLastWeek = 0;
//            (clone $baseQuery)
//            //->where('source', 'medium')
//            ->count();

        // Trial logic
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
