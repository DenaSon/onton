<?php

namespace App\Livewire\AdminDashboard\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class DrawerNotification extends Component
{

    public $notifications = [];


    public $notifyDrawer = false;


    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get();
    }


    public function render()
    {
        return view('livewire.admin-dashboard.notification.drawer-notification');
    }
}
