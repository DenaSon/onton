<?php

namespace App\Livewire\UserDashboard\Feed;

use App\Mail\ForwardNewsletterMailable;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Mary\Traits\Toast;

class FeedCard extends Component
{
    use Toast;

    public Newsletter $newsletter;

    public function getBodyPreviewProperty(): string
    {
        $paragraphs = preg_split('/\r\n|\r|\n/', strip_tags($this->newsletter->body_plain));
        $body = collect($paragraphs)->slice(2)->implode(' ');

        return \Str::limit($body, 250);
    }


    public function sendNewsletter(): void
    {
        $user = auth()->user();


        $rateKey = 'send-newsletter:' . $user->id . ':' . $this->newsletter->id;
        if (RateLimiter::tooManyAttempts($rateKey, 1)) {

            $secondsRemaining = RateLimiter::availableIn($rateKey);
            $minutes = ceil($secondsRemaining / 60);

            $this->warning('Please Wait', "You've already received this newsletter. Try again in {$minutes} minute(s).");


            return;
        }

        RateLimiter::hit($rateKey, 480);

        try {
            Mail::to($user->email)->queue(new ForwardNewsletterMailable($this->newsletter));
            $this->info('Sent!', 'Newsletter has been sent to your inbox.');
        } catch (\Throwable $e) {
            logger()->error('Newsletter sending failed', ['error' => $e]);
            $this->error('Failed', 'Unable to send newsletter right now.');
        }
    }

    public function view($id)
    {
        $this->dispatch('newsletterViewModal', id: $id);
    }


    public function render()
    {
        return view('livewire.user-dashboard.feed.feed-card');
    }
}
