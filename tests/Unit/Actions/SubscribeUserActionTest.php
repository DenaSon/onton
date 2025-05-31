<?php

namespace Tests\Unit\Actions;

use App\Actions\Home\SubscribeUserAction;
use App\Models\EmailContact;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Mockery;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Tests\TestCase;


class SubscribeUserActionTest extends TestCase
{
    use RefreshDatabase;


    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_user_can_subscribe_successfully()
    {

        $rateLimiter = Mockery::mock(RateLimiter::class);


        $rateLimiter->shouldReceive('attempt')
            ->once()
            ->andReturnUsing(function ($key, $maxAttempts, $callback, $decaySeconds) {

                $callback();
                return true;
            });

        $rateLimiter->shouldReceive('availableIn')
            ->never();

        $ip = '123.456.789.000';


        $action = new SubscribeUserAction($rateLimiter, $ip);

        $email = 'test@example.com';
        $source = 'test-source';

        $beforeCount = EmailContact::count();

        $result = $action->handle($email, $source);

        $this->assertTrue($result);

        $this->assertDatabaseCount('email_contacts', $beforeCount + 1);

        $contact = EmailContact::latest()->first();
        $this->assertEquals($email, $contact->email);
        $this->assertEquals($ip, $contact->ip_address);
        $this->assertEquals($source, $contact->source);
        $this->assertNotEmpty($contact->token);
        $this->assertTrue(Str::length($contact->token) === 40);
        $this->assertNotNull($contact->subscribed_at);
    }


    public function test_user_cannot_subscribe_if_rate_limited()
    {
        $rateLimiter = Mockery::mock(RateLimiter::class);

        $rateLimiter->shouldReceive('attempt')
            ->once()
            ->andReturnFalse();

        $rateLimiter->shouldReceive('availableIn')
            ->once()
            ->with('subscribe:111.222.333.444')
            ->andReturn(180); // e.g. 3 minutes left

        $ip = '111.222.333.444';
        $action = new SubscribeUserAction($rateLimiter, $ip);

        $email = 'denasoft@live.com';

        $this->expectException(TooManyRequestsHttpException::class);
        $this->expectExceptionMessage('Please try again in 180 Seconds.');
        $this->assertDatabaseMissing('email_contacts', ['email' => $email]);


        $action->handle($email);
    }



}
