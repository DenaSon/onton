<?php

namespace App\Livewire\AdminDashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('components.layouts.admin-dashboard')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard.index')->title('Byblos Dashboard');
    }
}
