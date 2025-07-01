<?php

namespace App\Livewire\AdminDashboard\Analytics\Overview;

use App\Models\Cashier\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class StatCard extends Component
{


    public $activeUsers = 0;
    public $trialUsers = 0;
    public $activeToday = 0;

    public function mount()
    {


        $this->activeUsers = User::where('is_suspended', 0)->count();


        $this->trialUsers = User::whereHas('subscriptions', fn($q) =>
        $q->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '>=', now())
        )->count();


        $this->activeToday = Subscription::where('stripe_status', 'active')
            ->whereDate('created_at', Carbon::today())
            ->distinct('user_id')
            ->count('user_id');

    }

    public function render()
    {
        return view('livewire.admin-dashboard.analytics.overview.stat-card');
    }
}
