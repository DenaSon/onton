<?php

namespace App\Livewire\AdminDashboard\Documents;

use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('components.layouts.admin-dashboard')]
class DocIndex extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard.documents.doc-index')->title('Admin Core Documents');
    }
}
