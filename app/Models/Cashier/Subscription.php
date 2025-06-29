<?php

namespace App\Models\Cashier;


use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'quantity',
        'trial_ends_at',
        'ends_at',

    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Check if the subscription is currently in a trial period.
     *
     * @return bool
     */
    public function isTrialing(): bool
    {
        return $this->stripe_status === 'trialing';
    }

    /**
     * Check if the subscription is canceled but still active (in a grace period).
     *
     * @return bool
     */
    public function isOnGracePeriod(): bool
    {
        return !is_null($this->ends_at) && $this->ends_at->isFuture();
    }

    /**
     * Check if the subscription has fully ended.
     *
     * @return bool
     */
    public function isEnded(): bool
    {
        return !is_null($this->ends_at) && $this->ends_at->isPast();
    }

    /**
     * Check if the subscription will renew soon (within 5 days).
     *
     * @return bool
     */
    public function isRenewingSoon(): bool
    {
        $nextBilling = $this->nextBillingDate();
        return $nextBilling && $nextBilling->diffInDays(now()) <= 5;
    }


    /**
     * Determine if the subscription is cancelled.
     *
     * @return bool
     */
    public function cancelled(): bool
    {
        return $this->stripe_status === 'canceled';
    }

    /**
     * Get the subscription's next billing date.
     * (only if no trial and no cancellation)
     *
     * @return CarbonInterface|null
     */
    public function nextBillingDate(): ?CarbonInterface
    {
        if ($this->isEnded()) {
            return null;
        }

        if ($this->onTrial()) {
            return $this->trial_ends_at;
        }

        return $this->asStripeSubscription()->current_period_end
            ? Carbon::createFromTimestamp($this->asStripeSubscription()->current_period_end)
            : null;
    }

    /**
     * Get a human-readable status label.
     *
     * @return string
     */
    public function getStatusLabel(): string
    {
        if ($this->isTrialing()) {
            return 'Trialing';
        }

        if ($this->active() && $this->cancelled()) {
            return 'Cancelling Soon';
        }

        if ($this->active()) {
            return 'Active';
        }

        if ($this->isOnGracePeriod()) {
            return 'Grace Period';
        }

        if ($this->isEnded()) {
            return 'Ended';
        }

        return ucfirst($this->stripe_status);
    }

    /**
     * Determine if the subscription is for the Basic plan.
     *
     * @return bool
     */
    public function isBasicPlan(): bool
    {
        return $this->stripe_price === 'price_basic_monthly'; // change based on your plan ID
    }

    /**
     * Determine if the subscription is for the Pro plan.
     *
     * @return bool
     */
    public function isProPlan(): bool
    {
        return $this->stripe_price === 'price_pro_monthly'; // change based on your plan ID
    }
}
