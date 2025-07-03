<?php

namespace App\Livewire\UserDashboard\Payment;

use App\Notifications\UserSystemNotification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

#[Layout('components.layouts.user-dashboard')]
class SubscriptionManagement extends Component
{
    use Toast;

    public $subscription = null;
    public $onTrial = false;
    public $trialEndsAt = null;
    public $planName = 'Unknown';
    public $nextBillingDate = null;


    public function mount()
    {
        $user = auth()->user();
        $this->subscription = $user->subscription('default');
        $this->onTrial = $user->onTrial('default');
        $this->trialEndsAt = $this->subscription?->trial_ends_at;

        $this->planName = match ($this->subscription?->stripe_price) {
            'price_basic' => 'Basic',
            'price_pro' => 'Pro',
            default => $this->onTrial ? 'Trial' : 'Unknown',
        };


        if ($this->subscription?->stripe_id) {
            Stripe::setApiKey(config('cashier.secret'));

            $stripeSubscription = StripeSubscription::retrieve($this->subscription->stripe_id);

            $this->nextBillingDate = \Carbon\Carbon::createFromTimestamp($stripeSubscription->current_period_end);
        } else {
            $this->nextBillingDate = null;
        }
    }

    public function cancelSubscription(): void
    {
        $key = 'cancel-subscription:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $this->addError('rate_limit', 'You are performing this action too frequently. Please wait a few minutes.');
            return;
        }

        RateLimiter::hit($key, 60);

        $this->subscription?->cancel();
        $this->info('Subscription Cancelled', 'Your subscription will remain active until the end of the billing cycle.');

        auth()->user()->notify(new UserSystemNotification(
            subject: 'Subscription Cancelled',
            title: 'Your subscription has been cancelled',
            message: 'Your subscription will remain active until the end of the current billing period. Thank you for being with us!',
            actionUrl: route('panel.payment.management'),
            actionText: 'View Plans',
            footerText: 'If you change your mind, you can always resubscribe anytime.'
        ));

        $this->mount(); // Refresh data
    }


    public function resumeSubscription(): void
    {
        $key = 'resume-subscription:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $this->addError('rate_limit', 'You are performing this action too frequently. Please wait a few minutes.');
            return;
        }

        RateLimiter::hit($key, 60); // 60 ثانیه محدودیت

        $this->subscription?->resume();
        $this->info('Subscription Resumed', 'Your subscription has been resumed and will continue as usual.');
        $this->mount(); // Refresh data
    }


    public function render()
    {
        $user = auth()->user();


        $cacheKey = 'stripe_invoices_user_' . $user->id;

        // Try to get from cache, otherwise fetch from Stripe and cache it for 5 minutes
        $invoices = cache()->remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $user->invoices();
        });

        return view('livewire.user-dashboard.payment.subscription-management')
            ->with(compact('invoices'))
            ->title('Subscription Management');
    }

}
