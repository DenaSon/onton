<?php

namespace App\Livewire\UserDashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('components.layouts.user-dashboard')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.user-dashboard.index');
    }
}
