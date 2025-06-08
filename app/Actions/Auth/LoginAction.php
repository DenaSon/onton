<?php

namespace App\Actions\Auth;


use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;



/**
 * Handles user login authentication with rate limiting.
 *
 * This action attempts to authenticate a user using their email and password,
 * applies rate limiting to prevent brute-force attacks, and regenerates the session upon successful login.
 *
 * @package App\Actions\Auth
 */

class LoginAction
{
    /**
     * LoginAction constructor.
     *
     * @param RateLimiter $rateLimiter Rate limiter instance to throttle login attempts.
     * @param StatefulGuard $auth Authentication guard responsible for user authentication.
     * @param SessionManager $session Session manager to handle session regeneration after login.
     * @param Request $request Current HTTP request instance to retrieve client IP.
     */
    public function __construct(
        protected RateLimiter $rateLimiter,
        protected StatefulGuard $auth,
        protected SessionManager $session,
        protected Request $request
    ) {}


    /**
     * Attempt to authenticate the user with given credentials.
     *
     * Applies rate limiting based on email and IP to protect against brute force attacks.
     * Upon successful authentication, clears rate limit and regenerates session.
     *
     * @param string $email The email address of the user attempting to login.
     * @param string $password The password associated with the email.
     * @param bool $remember Whether to remember the user (persistent login).
     *
     * @throws ValidationException If authentication fails or rate limit is exceeded.
     *
     * @return void
     */
    public function handle(string $email, string $password, bool $remember = false): void
    {
        $this->rateLimit($email);

        if (!$this->auth->attempt(['email' => $email, 'password' => $password], $remember)) {
            throw ValidationException::withMessages([
                'email' => __('The provided credentials are incorrect.'),
            ]);
        }

        $this->rateLimiter->clear($this->throttleKey($email));

        $this->session->regenerate();

    }

    /**
     * Enforce rate limiting for login attempts per email and IP address.
     *
     * Throws a validation exception if the number of attempts exceeds the threshold.
     *
     * @param string $email The email to generate the throttle key.
     *
     * @throws ValidationException When too many login attempts occur.
     *
     * @return void
     */
    protected function rateLimit(string $email): void
    {
        $key = $this->throttleKey($email);

        if ($this->rateLimiter->tooManyAttempts($key, 3)) {
            throw ValidationException::withMessages([
                'email' => __('Too many login attempts. Please try again in :seconds seconds.', [
                    'seconds' => $this->rateLimiter->availableIn($key),
                ]),
            ]);
        }

        $this->rateLimiter->hit($key, 100);
    }



    /**
     * Generate a unique throttle key for the given email and request IP.
     *
     * This key is used to track login attempts per user and IP combination.
     *
     * @param string $email The email address to include in the throttle key.
     *
     * @return string The generated throttle key.
     */
    protected function throttleKey(string $email): string
    {
        return Str::lower($email) . '|' . $this->request->ip();
    }
}
