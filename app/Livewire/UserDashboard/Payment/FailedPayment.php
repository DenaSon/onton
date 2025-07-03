<?php

namespace App\Livewire\UserDashboard\Payment;

use App\Notifications\UserSystemNotification;
use Livewire\Component;

class FailedPayment extends Component
{
    public function mount()
    {
        if (!session()->pull('payment_in_progress')) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        $user->notify(new UserSystemNotification(
            subject: '❌ Payment Failed',
            title: 'Oops! Something went wrong.',
            message: 'We couldn’t process your payment. Please try again.',
            actionUrl: route('panel.index'),
            actionText: 'Try Again'
        ));

    }
    public function render()
    {
        return view('livewire.user-dashboard.payment.failed-payment')->layout('components.layouts.user-dashboard')->title('Activation Failed');
    }
}
