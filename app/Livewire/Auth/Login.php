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
            $this->warning('Sign In failed', 'These credentials do not match our records.', timeout: 5500);
            logger()->warning('Login exception: '.$e->getMessage(), [
                'email' => $this->email,
                'ip' => request()->ip(),
            ]);

            $this->addError('password', __('These credentials do not match our records.'));


        }
    }

    public function render()
    {
        return view('livewire.auth.login')->title('Sign In');
    }



}
