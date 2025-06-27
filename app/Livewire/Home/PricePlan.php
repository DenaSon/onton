<?php

namespace App\Livewire\Home;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class PricePlan extends Component
{
    use Toast;



    public function subscribe()
    {
        if (!Auth::check()) {
            $this->redirectRoute('login');
            return;
        }

        if (!Auth::user()->hasVerifiedEmail()) {
            $this->error('Payment Error', 'Please verify your email before subscribing.');
            return;
        }

        $user = Auth::user();

        return $user->newSubscription('default', 'price_1RebzlP6tOy2de8NRFvjB45u')
            ->checkout([
                'success_url' => route('home') . '?subscribed=1',
                'cancel_url' => route('home'),
            ]);
    }


    public function render()
    {
        return view('livewire.home.price-plan');
    }
}
