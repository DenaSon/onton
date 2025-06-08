<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\LoginAction;
use Livewire\Component;
use Mary\Traits\Toast;
use Throwable;


class Login extends Component
{
    use Toast;
    public $class ='';

    public $email ='';
    public $password ='';
    public $remember = false;

    public function login(LoginAction $action)
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $action->handle($this->email, $this->password, $this->remember);

            if (auth()->check()) {
                return auth()->user()->hasRole('admin')
                    ? redirect()->intended(route('core.index'))
                    : redirect()->intended(route('panel.index'));
            }


        }
        catch (Throwable $e) {
            $this->warning('Sign In failed', $e->getMessage(), timeout: 5000);

            $this->addError('email', $e->getMessage());
            $this->addError('password', __('These credentials do not match our records.'));

        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }



}
