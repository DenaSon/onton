<?php

namespace App\Livewire\Auth;

use App\Actions\Fortify\CreateNewUser;
use Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Mary\Traits\Toast;
use Str;

class Register extends Component
{
    use Toast;

    public $class;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function register(CreateNewUser $newUser)
    {

        $this->rateLimit();



        $user = $newUser->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);


        Auth::login($user);


        return redirect()->route('dashboard');


    }


    protected function rateLimit()
    {
        $key = Str::lower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 4)) {
            throw ValidationException::withMessages([
                'email' => __('Too many attempts. Please try again in :seconds seconds.', [
                    'seconds' => RateLimiter::availableIn($key),
                ]),
            ]);
        }

        RateLimiter::hit($key, 60); // 5 attempts per 60 seconds
    }


    public function render()
    {
        return view('livewire.auth.register');
    }
}
