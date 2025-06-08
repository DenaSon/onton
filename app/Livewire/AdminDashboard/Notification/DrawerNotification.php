<?php

namespace App\Livewire\AdminDashboard\Notification;

use Livewire\Component;

class DrawerNotification extends Component
{

    public $notifyDrawer = false;

    public function render()
    {
        return view('livewire.admin-dashboard.notification.drawer-notification');
    }
}
