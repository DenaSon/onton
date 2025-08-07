<?php

namespace App\Livewire\UserDashboard\Payment;

use App\Notifications\UserSystemNotification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;
use Stripe\Exception\ApiErrorException;
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

    public $planPrice = null;
    public $planCurrency = null;

    public array $invoices = [];

    public function mount()
    {
        $user = auth()->user();
        $this->subscription = $user->subscription('default');
        $this->onTrial = $user->onTrial('default');
        $this->trialEndsAt = $this->subscription?->trial_ends_at;

    }


    /**
     * @throws ApiErrorException
     */
    public function loadStripeSubscriptionData(): void
    {
        if (!$this->subscription?->stripe_id) {
            $this->nextBillingDate = null;
            return;
        }

        Stripe::setApiKey(config('cashier.secret'));

        $stripeSubscription = StripeSubscription::retrieve($this->subscription->stripe_id);

        $this->nextBillingDate = \Carbon\Carbon::createFromTimestamp($stripeSubscription->current_period_end);


        $priceId = $stripeSubscription->items->data[0]->price->id ?? null;

        if ($priceId) {
            $price = \Stripe\Price::retrieve($priceId);

            $this->planPrice = number_format($price->unit_amount / 100, 2);
            $this->planCurrency = strtoupper($price->currency);
        }

    }

    public function loadInvoices(): void
    {
        $user = auth()->user();
        $cacheKey = 'stripe_invoices_user_' . $user->id;

        $this->invoices = cache()->remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $user->invoices()->map(function ($invoice) {
                return [
                    'total' => $invoice->total(),
                    'date' => $invoice->date()->format('M d, Y'),
                    'url' => $invoice->hosted_invoice_url,
                ];
            })->toArray();
        });
    }

    public function cancelSubscription(): void
    {
        $key = 'cancel-subscription:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $this->addError('rate_limit', 'You are performing this action too frequently. Please wait a few minutes.');
            return;
        }

        RateLimiter::hit($key, 60);
        if (!$this->subscription) {
            $this->addError('subscription', 'You do not have an active subscription.');
            return;
        }
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
        cache()->forget('stripe_invoices_user_' . auth()->id());

        $this->mount(); // Refresh data
    }


    public function resumeSubscription(): void
    {
        $key = 'resume-subscription:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $this->addError('rate_limit', 'You are performing this action too frequently. Please wait a few minutes.');
            return;
        }

        RateLimiter::hit($key, 60);

        if (!$this->subscription) {
            $this->addError('subscription', 'You do not have an active subscription.');
            return;
        }

        $this->subscription?->resume();
        $this->info('Subscription Resumed', 'Your subscription has been resumed and will continue as usual.');

        auth()->user()->notify(new UserSystemNotification(
            subject: 'Subscription resume',
            title: 'Your subscription has been resumed',
            message: 'Your subscription resume again',
            actionUrl: route('panel.payment.management'),
            actionText: 'View Plans',
            footerText: 'Resume subscription successfully.',
        ));


        cache()->forget('stripe_invoices_user_' . auth()->id());

        $this->mount();
    }


    public function render()
    {

        return view('livewire.user-dashboard.payment.subscription-management')
            ->title('Subscription Management');
    }

}
