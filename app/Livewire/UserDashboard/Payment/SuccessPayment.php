<?php

namespace App\Livewire\UserDashboard\Payment;

use Livewire\Component;

class SuccessPayment extends Component
{
    public function render()
    {
        return view('livewire.user-dashboard.payment.success-payment')
            ->layout('components.layouts.user-dashboard')->title('Trial Activation');
    }
}
