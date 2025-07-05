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

    public function mount()
    {
        $user = Auth::user();
        $setting = $user?->notificationSetting;

        $this->frequency = $setting?->frequency ?? 'daily';
        $this->lastSentAt = $setting?->last_sent_at;
    }

    public function save()
    {
        if (! $this->rateLimit()) {
            return;
        }
        $this->validate();


        $user = Auth::user();
        $user->notificationSetting()->updateOrCreate([], [
            'frequency' => $this->frequency,
        ]);

       $this->success('Setting Updated','Delivery Settings Saved successfully');
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

    public function render()
    {
        return view('livewire.user-dashboard.setting.delivery-setting');
    }
}
