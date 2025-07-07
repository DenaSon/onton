<?php

namespace App\Livewire\Auth;

use App\Actions\Fortify\CreateNewUser;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;
use Str;
use Throwable;
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
        try {
            event(new Registered($user));
        } catch (\Throwable $e) {

            activity()
                ->causedBy($user)
                ->event('RegisteredEvent')
                ->performedOn($user)
                ->withProperties([
                    'event_class' => Registered::class,
                    'ip' => request()->ip(),
                    'error_message' => $e->getMessage(),
                ])
                ->log('Failed to dispatch Registered event');

            Log::error('Registered event failed for user ID: ' . $user->id, [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);


            Log::error('Registered event failed for user ID: ' . $user->id, [
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }


        return redirect()->route('verification.notice');


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
        return view('livewire.auth.register')->title('Sign Up');
    }
}
