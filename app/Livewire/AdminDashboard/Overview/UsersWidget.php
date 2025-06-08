<?php

namespace App\Livewire\AdminDashboard\Overview;

use Livewire\Attributes\Lazy;
use Livewire\Component;
#[Lazy]
class UsersWidget extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard.overview.users-widget');
    }
}
