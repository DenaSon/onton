<?php

namespace App\Livewire\AdminDashboard\Overview;

use App\Models\User;
use Livewire\Attributes\Lazy;
use Livewire\Component;

class UsersWidget extends Component
{
    public function render()
    {
        $users = User::limit(10)->latest('created_at')->get();
        return view('livewire.admin-dashboard.overview.users-widget',compact('users'));
    }
}
