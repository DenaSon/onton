<?php

namespace App\Livewire\AdminDashboard\Crawler;

use App\Models\Newsletter;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-dashboard')]
class NewsletterShowDetails extends Component
{
    public Newsletter $newsletter;

    public function mount(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter->load('vc');
    }

    public function render()
    {
        return view('livewire.admin-dashboard.crawler.newsletter-show-details');
    }
}
