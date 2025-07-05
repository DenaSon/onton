<?php

namespace App\Livewire\Components\Dashboard;

use Livewire\Attributes\Lazy;
use Livewire\Component;
class NavbarNotification extends Component
{
    public function markAsRead($notificationId): void
    {
        $notification = auth()->user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }
    }


    public function render()
    {
        $notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->limit(5)
            ->get();
        return view('livewire.components.dashboard.navbar-notification', compact('notifications'));
    }
}
