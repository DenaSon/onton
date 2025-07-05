<?php

namespace App\Livewire\UserDashboard\Setting;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.user-dashboard')]
#[Title('Newsletters Delivery Setting')]
class DeliverySetting extends Component
{
    use Toast;

    #[Validate('required|in:daily,weekly')]
    public string $frequency = 'daily';
    public ?Carbon $lastSentAt = null;

    public function mount(): void
    {
        $setting = Auth::user()?->notificationSetting;

        $this->frequency = $setting?->frequency ?? 'daily';
        $this->lastSentAt = $setting?->last_sent_at;
    }

    public function save(): void
    {
        if (! $this->rateLimit()) return;

        $this->validate();

        if (! $this->checkSubscriptionAccess()) return;

        Auth::user()->notificationSetting()->updateOrCreate([], [
            'frequency' => $this->frequency,
        ]);

        $this->success('Setting Updated', 'Delivery Settings Saved successfully');
    }

    protected function rateLimit(): bool
    {
        $key = 'delivery-setting-save:' . Auth::id();

        if (RateLimiter::tooManyAttempts($key, 6)) {
            $this->warning('Too Many Attempts', 'Please wait before trying again.');
            return false;
        }

        RateLimiter::hit($key, 80); // 80-second decay
        return true;
    }

    protected function checkSubscriptionAccess(): bool
    {
        if (! Auth::user()?->hasActiveSubscription()) {
            $this->warning('Subscription Needed', 'This feature is available with an active subscription or free trial. Upgrade now to unlock it.');
            return false;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.user-dashboard.setting.delivery-setting');
    }
}
