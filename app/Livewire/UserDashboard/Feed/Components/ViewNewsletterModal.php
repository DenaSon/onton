<?php

namespace App\Livewire\UserDashboard\Feed\Components;

use App\Models\Newsletter;
use Livewire\Component;

class ViewNewsletterModal extends Component
{
    public bool $newsletterViewModal = false;
    public ?int $newsletterId = null;


    protected $listeners = ['newsletterViewModal' => 'open'];

    public function open(int $id): void
    {
        $this->newsletterId = $id;

        $this->newsletterViewModal = true;
    }

    public function render()
    {
        return view('livewire.user-dashboard.feed.components.view-newsletter-modal');
    }
}

