<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;

use Livewire\Component;
use Mary\Traits\Toast;

class ForgotPassword extends Component
{
    use Toast;
    public $class='';

    public string $email = '';

    public string $status = '';

    public function sendResetLink()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
           $this->success('Send Password Reset Link',__($status));

        } else {
            $this->warning('Send Password Reset Link Failed',__($status));
        }
    }
    public function render()
    {
        return view('livewire.auth.forgot-password')->title('Forgot Password');
    }
}
