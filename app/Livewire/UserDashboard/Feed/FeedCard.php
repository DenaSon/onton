<?php

namespace App\Livewire\UserDashboard\Feed;

use App\Models\Newsletter;
use Livewire\Component;

class FeedCard extends Component
{
    public Newsletter $newsletter;


    public function getBodyPreviewProperty(): string
    {
        $paragraphs = preg_split('/\r\n|\r|\n/', strip_tags($this->newsletter->body_plain));
        $body = collect($paragraphs)->slice(2)->implode(' ');

        return \Str::limit($body, 200);
    }


    public function render()
    {
        return view('livewire.user-dashboard.feed.feed-card');
    }
}
