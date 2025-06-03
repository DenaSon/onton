<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Mary\Traits\Toast;

class PricePlan extends Component
{
    use Toast;






    public function trialStart(): void
    {
        $this->success(
            'Plan <u>updated</u>',
            'Avtive Byblos Radar Plan  : <strong> Successfully </strong>',
            position: 'bottom-end',
            icon: 'o-credit-card',
            css: 'bg-primary text-base-100'
        );
    }

    public function render()
    {
        return view('livewire.home.price-plan');
    }
}
