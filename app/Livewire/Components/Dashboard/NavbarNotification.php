<?php

namespace App\Livewire\Components\Dashboard;

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
        $notifications = auth()->user()?->unreadNotifications->take(5);
        return view('livewire.components.dashboard.navbar-notification', compact('notifications'));
    }
}
