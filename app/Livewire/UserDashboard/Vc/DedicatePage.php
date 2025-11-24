<?php

namespace App\Livewire\UserDashboard\Vc;

use App\Models\Vc;
use Livewire\Component;
use Livewire\WithPagination;

class DedicatePage extends Component
{
    use WithPagination;

    public Vc $vc;
    public bool $isPremiumView = false; // آیا کاربر دسترسی کامل دارد؟

    public function mount($slug, Vc $vcid)
    {
        $this->vc = $vcid;

        // تعیین سطح دسترسی کاربر
        $this->isPremiumView = $this->checkPremiumAccess();
    }

    /**
     * Determine if user has trial/subscription.
     */
    private function checkPremiumAccess(): bool
    {

        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();


        if ($user->onTrial('default')) {
            return true;
        }

        // اگر subscription فعال دارد → دسترسی کامل
        if ($user->subscribed('default')) {
            return true;
        }

        // باقی حالت‌ها → public view
        return false;
    }

    /**
     * Fetch newsletters based on access.
     */
    private function getNewsletters()
    {
        if ($this->isPremiumView) {
            // حالت premium → paginate
            return $this->vc->newsletters()
                ->latest()
                ->paginate(15);
        }

        // حالت public → محدود و بدون pagination
        return $this->vc->newsletters()
            ->latest()
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.user-dashboard.vc.dedicate-page', [
            'vc' => $this->vc,
            'newsletters' => $this->getNewsletters(),
            'isPremium' => $this->isPremiumView,
        ])->layout('components.layouts.app')
            ->title('VC: ' . ($this->vc->name ?? ''));
    }
}
