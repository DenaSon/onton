<?php

namespace App\Livewire\UserDashboard\Feed\Components;

use App\Models\Newsletter;
use Livewire\Component;

class ViewNewsletterModal extends Component
{
    public $newsletterViewModal = false;
    public $newsletter;

    protected $listeners = ['newsletterViewModal' => 'open'];

    public function open($id): void
    {


        $this->newsletterViewModal = true;

        $this->newsletter = Newsletter::findOrfail($id);

    }


    public function render()
    {
        return view('livewire.user-dashboard.feed.components.view-newsletter-modal');
    }
}
