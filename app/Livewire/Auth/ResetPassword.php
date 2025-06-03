<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Mary\Traits\Toast;

class ResetPassword extends Component
{
    use Toast;

    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $token;

    public function mount(string $token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');

    }

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $this->success('Password Reset Successful', __('Your password has been updated.'),timeout: 5000);
            return redirect()->route('login');
        } else {
            $this->error('Reset Failed', __($status),timeout: 5000,redirectTo: route('login'));
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
