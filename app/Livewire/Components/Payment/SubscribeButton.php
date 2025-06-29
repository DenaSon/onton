<?php

namespace App\Livewire\Components\Payment;

use App\Models\Cashier\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class SubscribeButton extends Component
{
    use Toast;

    public $label;
    public $icon;
    public $class;


    public function subscribe()
    {
        if (!Auth::check()) {
            $this->redirectRoute('login');
            return;
        }

        if (!Auth::user()->hasVerifiedEmail()) {
            $this->error('Payment Error', 'Please verify your email before subscribing.');
            return;
        }

        $user = Auth::user();
        /** @var Subscription|null $subscription */
        $subscription = $user->subscription('default');

        if ($subscription && $subscription->active()) {
            $this->info('Subscription Active', 'You already have an active subscription until: '. optional($subscription->nextBillingDate())->diffForHumans());
            return;
        }

        if ($subscription && ($subscription->onTrial() || $subscription->onGracePeriod())) {
            $this->info('Subscription Pending', 'You already have a subscription in trial or grace period.');
            return;
        }

        return $user
            ->newSubscription('default', 'price_1RebzlP6tOy2de8NRFvjB45u')

            ->trialDays(30)
            ->checkout([
                'success_url' => route('home') . '?subscribed=1',
                'cancel_url' => route('home'),
            ]);
    }


    public function render()
    {
        return view('livewire.components.payment.subscribe-button');
    }
}
