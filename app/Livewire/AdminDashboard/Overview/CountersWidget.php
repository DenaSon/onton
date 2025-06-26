<?php

namespace App\Livewire\AdminDashboard\Overview;

use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;

class CountersWidget extends Component
{

    public int $totalUsers = 0;
    public ?float $growth = null;

    public int $weeklyActiveSubscriptions = 0;

    public ?float $subscriptionsGrowth = null;

    public int $newslettersLast24h = 0;
    public int $vcFirmsTotal = 0;
    public int $vcFirmsThisWeek = 0;


    public function mount(): void
    {

        $this->calculateUserStats();
        $this->calculateSubscriptionStats();
        $this->calculateNewsletterStats();
        $this->calculateVCStats();
    }

    protected function calculateNewsletterStats(): void
    {
        $this->newslettersLast24h = \App\Models\Newsletter::where('created_at', '>=', now()->subDay())->count();
    }

    protected function calculateVCStats(): void
    {
        $this->vcFirmsTotal = \App\Models\Vc::count();

        $this->vcFirmsThisWeek = \App\Models\Vc::where('created_at', '>=', now()->startOfWeek())->count();
    }



    protected function calculateUserStats(): void
    {
        $this->totalUsers = User::count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $usersThisMonth = User::where('created_at', '>=', $startOfMonth)->count();

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $usersLastMonth = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        if ($usersLastMonth > 0) {
            $this->growth = (($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100;
        }
    }


    protected function calculateSubscriptionStats(): void
    {
        $now = Carbon::now();
        $startOfThisWeek = $now->copy()->startOfWeek();
        $startOfLastWeek = $now->copy()->subWeek()->startOfWeek();
        $endOfLastWeek = $now->copy()->subWeek()->endOfWeek();

        // Count active subscriptions created this week
        $this->weeklyActiveSubscriptions = \Laravel\Cashier\Subscription::query()
            ->where('stripe_status', 'active')
            ->where('created_at', '>=', $startOfThisWeek)
            ->count();

        // Count active subscriptions created last week
        $subscriptionsLastWeek = \Laravel\Cashier\Subscription::query()
            ->where('stripe_status', 'active')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->count();

        // Calculate % growth
        if ($subscriptionsLastWeek > 0) {
            $this->subscriptionsGrowth = (($this->weeklyActiveSubscriptions - $subscriptionsLastWeek) / $subscriptionsLastWeek) * 100;
        }
    }



    public function render()
    {
        return view('livewire.admin-dashboard.overview.counters-widget');
    }


}
