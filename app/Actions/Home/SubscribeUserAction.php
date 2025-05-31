<?php

namespace App\Actions\Home;

use App\Models\EmailContact;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class SubscribeUserAction
{

    protected RateLimiter $rateLimiter;
    protected ?string $ipAddress;

    public function __construct(RateLimiter $rateLimiter, ?string $ipAddress = null)
    {
        $this->rateLimiter = $rateLimiter;
        $this->ipAddress = $ipAddress ?: request()->ip();
    }



    /**
     * Handle the user subscription.
     *
     * @param string $email
     * @param string|null $source
     * @return bool
     *
     * @throws TooManyRequestsHttpException
     */
    public function handle(string $email, ?string $source = null): bool
    {
        $requestIp = $this->ipAddress ?? request()->ip();

        $key = 'subscribe:' .  ($requestIp ?? '');

        $allowed = $this->rateLimiter->attempt($key, 3, function () use ($email, $requestIp, $source) {
            EmailContact::create([
                'email' => $email,
                'token' => Str::random(40),
                'ip_address' => $requestIp,
                'source' => $source,
                'subscribed_at' => now(),
            ]);
        }, 240);

        if (! $allowed) {
            $seconds = $this->rateLimiter->availableIn($key);

            throw new TooManyRequestsHttpException(
                $seconds,
                ' Please try again in ' . $seconds .' Seconds.'
            );
        }

        return true;
    }
}
