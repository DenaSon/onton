<?php

namespace App\Livewire\UserDashboard\Vc;

use App\Models\Vc;
use Livewire\Component;


class DedicatePage extends Component
{

    public Vc $vc;


    public function mount($slug, Vc $vcid)
    {

        $this->vc = $vcid;
    }


    public function render()
    {
        return view('livewire.user-dashboard.vc.dedicate-page', [
            'vc' => $this->vc
        ])->layout('components.layouts.app')->title('VC:' . $this->vc->name ?? '');
    }
}
