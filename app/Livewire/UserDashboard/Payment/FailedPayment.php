<?php

namespace App\Livewire\UserDashboard\Payment;

use Livewire\Component;

class FailedPayment extends Component
{
    public function render()
    {
        return view('livewire.user-dashboard.payment.failed-payment')->layout('components.layouts.user-dashboard')->title('Activation Failed');
    }
}
