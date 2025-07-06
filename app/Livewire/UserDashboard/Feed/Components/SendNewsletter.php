<?php

namespace App\Livewire\UserDashboard\Feed\Components;

use App\Mail\ForwardNewsletterMailable;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Mary\Traits\Toast;

class SendNewsletter extends Component
{
    use Toast;

    protected $listeners = ['sendNewsletter'];

    public function sendNewsletter(int $id): void
    {
        $newsletter = Newsletter::findOrFail($id);

        $user = auth()->user();

        if (!$user->can('receive', $newsletter)) {
            $this->error('Unauthorized', 'You are not allowed to receive this newsletter.');
            return;
        }


        $rateKey = "send-newsletter:{$user->id}:{$newsletter->id}";

        if (RateLimiter::tooManyAttempts($rateKey, 1)) {
            $minutes = ceil(RateLimiter::availableIn($rateKey) / 60);
            $this->warning('Please Wait', "You've already received this newsletter. Try again in {$minutes} minute(s).");
            return;
        }

        RateLimiter::hit($rateKey, 480);

        try {
            Mail::to($user->email)->queue(new ForwardNewsletterMailable($newsletter));
            $this->info('Sent!', 'Newsletter has been sent to your inbox.');
        } catch (\Throwable $e) {
            logger()->error('Newsletter sending failed', ['error' => $e]);
            $this->error('Failed', 'Unable to send newsletter right now.');
        }
    }

    public function render()
    {
        return view('livewire.user-dashboard.feed.components.send-newsletter');
    }
}
