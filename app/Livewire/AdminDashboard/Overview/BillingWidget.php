<?php

namespace App\Livewire\AdminDashboard\Overview;

use Livewire\Attributes\Lazy;
use Livewire\Component;

class BillingWidget extends Component
{

    public int $activeSubscriptions = 0;
    public int $cancelledSubscriptions = 0;
    public float $monthlyRevenue = 0.0;
    public ?string $lastPaymentDateDiff = null;


    protected function loadBillingData(): void
    {
        $now = now();

        $this->activeSubscriptions = \Laravel\Cashier\Subscription::where('stripe_status', 'active')->count();

        $this->cancelledSubscriptions = \Laravel\Cashier\Subscription::whereIn('stripe_status', ['canceled', 'cancelled', 'ended'])->count();

        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $this->monthlyRevenue = \Laravel\Cashier\Invoice::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('paid', true)
                ->sum('total') / 100;

        $lastInvoice = \Laravel\Cashier\Invoice::where('paid', true)
            ->orderByDesc('created_at')
            ->first();

        $this->lastPaymentDateDiff = $lastInvoice ? $lastInvoice->created_at->diffForHumans() : 'No payments yet';
    }


    public function render()
    {
        return view('livewire.admin-dashboard.overview.billing-widget');
    }
}
