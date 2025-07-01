<?php

namespace App\Livewire\UserDashboard\Feed;

use App\Models\Newsletter;
use Livewire\Component;

class FeedCard extends Component
{
    public Newsletter $newsletter;


    public function render()
    {
        return view('livewire.user-dashboard.feed.feed-card');
    }
}
