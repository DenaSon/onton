<?php

namespace App\Livewire\UserDashboard\Payment;

use App\Notifications\UserSystemNotification;
use Livewire\Component;

class SuccessPayment extends Component
{

    public function mount()
    {
        if (!session()->pull('payment_in_progress')) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();

        if ($user->subscribed('default') && $user->onTrial()) {
            $user->notify(new UserSystemNotification(
                subject: 'Payment Successful - Trial Activated',
                title: 'Hi ' . $user->name . '!',
                message: 'Your free trial is now active and will expire on ' . $user->trialEndsAt('default')?->format('F j, Y') . '.',
                actionUrl: route('panel.index'),
                actionText: 'Go to Dashboard'
            ));
        }

    }

    public function render()
    {
        return view('livewire.user-dashboard.payment.success-payment')
            ->layout('components.layouts.user-dashboard')->title('Trial Activation');
    }
}
