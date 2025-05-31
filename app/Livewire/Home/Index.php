<?php

namespace App\Livewire\Home;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use Toast;
    public function clickMe()
    {
        $this->success('YES','This is me ;)',position: 'toast-top toast-start');

    }


    public function render()
    {
        return view('livewire.home.index');
    }
}
