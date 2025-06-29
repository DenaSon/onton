<?php

namespace App\Livewire\Home;

use App\Models\Cashier\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class PricePlan extends Component
{

    public function render()
    {
        return view('livewire.home.price-plan');
    }
}
