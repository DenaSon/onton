<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Jenssegers\Agent\Agent;

class UserAuthEventSubscriber
{
    protected function logActivity(?object $user, string $eventName, string $message): void
    {
        $agent = new Agent();

        $activity = activity('authenticate')
            ->event($eventName)
            ->withProperties([
                'ip' => request()->ip() ?? 'N/A',
                'role' => method_exists($user, 'getRoleNames') ? $user->getRoleNames()->first() : null,
                'referer' => request()->header('referer') ??'N/A',
                'url' => request()->fullUrl() ?? 'N/A',
                'guard' => auth()->getDefaultDriver() ?? 'N/A',
                'device' => $agent->device() ?? 'N/A',
                'platform' => $agent->platform() ?? 'N/A',
                'platform_version' => $agent->version($agent->platform()) ?? 'N/A',
                'browser' => $agent->browser() ?? 'N/A',
                'browser_version' => $agent->version($agent->browser()) ?? 'N/A',
                'is_mobile' => $agent->isMobile(),
                'is_desktop' => $agent->isDesktop(),
                'is_robot' => $agent->isRobot(),
            ]);

        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
            $activity->causedBy($user);
        }

        $activity->log($message);
    }


    public function handleUserLogin(Login $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $this->logActivity(
            $user,
            'Login',
            __('User logged in with email: :email', ['email' => $user->email])
        );
    }

    public function handleUserRegistered(Registered $event): void
    {
        $user = $event->user;

        $this->logActivity(
            $user,
            'Register',
            __('User registered with email: :email', ['email' => $user->email])
        );
    }

    public function handleUserLogout(Logout $event): void
    {
        $user = $event->user;

        $this->logActivity(
            $user,
            'Logout',
            __('User logged out with email: :email', ['email' => $user->email])
        );
    }

    public function handleUserLoginFailed(Failed $event): void
    {
        $user = $event->user;

        $this->logActivity(
            $user,
            'FailedLogin',
            __('Failed login with email: :email', ['email' => $user->email])
        );
    }

    public function handlePasswordReset(PasswordReset $event): void
    {
        $user = $event->user;

        $this->logActivity(
            $user,
            'PasswordReset',
            __('Password reset for user with email: :email', ['email' => $user->email])
        );
    }

    public function handleUserVerified(Verified $event): void
    {
        $user = $event->user;

        $this->logActivity(
            $user,
            'EmailVerified',
            __('Email verified for user with email: :email', ['email' => $user->email])
        );
    }


}
