<?php

namespace App\Livewire\AdminDashboard\Overview;

use App\Models\Cashier\Subscription as CustomSubscription;
use Livewire\Component;

class BillingWidget extends Component
{
    public int $activeSubscriptions = 0;
    public int $cancelledSubscriptions = 0;
    public float $estimatedRevenue = 0.0;
    public ?string $lastSubscriptionDateDiff = null;

    public function loadBillingData(): void
    {


        $this->activeSubscriptions = CustomSubscription::whereIn('stripe_status', ['active', 'trialing'])->count();

        $this->cancelledSubscriptions = CustomSubscription::whereIn('stripe_status', ['canceled', 'cancelled', 'ended'])->count();

        $this->estimatedRevenue = $this->activeSubscriptions * 9.99;

        $lastSubscription = \App\Models\Cashier\Subscription::where('stripe_status', 'active')
            ->orWhere('stripe_status', 'trialing')
            ->orderByDesc('created_at')
            ->first();

        $this->lastSubscriptionDateDiff = $lastSubscription
            ? $lastSubscription->created_at->diffForHumans()
            : 'No active subscriptions';
    }

    public function render()
    {
        return view('livewire.admin-dashboard.overview.billing-widget');
    }
}
