<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Mary\Traits\Toast;

class VerifyEmail extends Component
{
    use Toast;

    public function resend()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(config('fortify.home'));
        }

        if (RateLimiter::tooManyAttempts('resend-verification:' . $user->id, 1)) {
            $this->error('Too many attempts', 'Please wait a few minutes before trying again.');
            return null;
        }

        try {
            $user->sendEmailVerificationNotification();

            RateLimiter::hit('resend-verification:' . $user->id);
            $this->success('Verification email sent', 'Please check your inbox.');
        } catch (\Throwable $e) {
            activity()
                ->causedBy($user)
                ->event('Verification Resend Failed')
                // ->performedOn($user)
                ->withProperties([
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'error_message' => $e->getMessage(),
                ])
                ->log('Failed to resend verification email.');

            $this->error('Something went wrong', 'We could not send the verification email. Please try again later.');
        }

    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
