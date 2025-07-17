<?php

namespace App\Livewire\UserDashboard\Documents;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.user-dashboard')]
#[Title('Help Center')]
class DocIndex extends Component
{
    public function render()
    {
        return view('livewire.user-dashboard.documents.doc-index');
    }
}
