<?php

namespace App\Livewire\Home;

use App\Actions\Home\SubscribeUserAction;
use Livewire\Component;
use Mary\Traits\Toast;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class SubscribeForm extends Component
{
    use Toast;

    public $email;

    public function saveNewsletterEmail(SubscribeUserAction $action): void
    {
        $this->validate([
            'email' => 'required|email|max:255|unique:email_contacts,email',
        ]);


        try {
            $source = 'newsletter';
            $email = $this->email;
            $action->handle($email, $source);
            $this->info('Subscribed successfully.');
            $this->reset('email');
        } catch (TooManyRequestsHttpException $e) {
            $this->error('Something went wrong.', $e->getMessage() );
        }

    }


    public function render()
    {
        return view('livewire.home.subscribe-form');
    }
}
