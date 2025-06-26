<?php

namespace App\Livewire\AdminDashboard\Overview;

use App\Models\Newsletter;
use Livewire\Component;

class CrawlerStatusWidget extends Component
{

    public $newsletters;

    public function mount()
    {
        $this->loadLatestNewsletters();
    }

    public function loadLatestNewsletters()
    {

        $this->newsletters = Newsletter::with('vc')
            ->orderByDesc('received_at')
            ->limit(10)
            ->get(['newsletters.id','newsletters.from_email', 'newsletters.subject', 'newsletters.processing_status', 'newsletters.received_at', 'newsletters.vc_id']);
    }



    public function render()
    {
        return view('livewire.admin-dashboard.overview.crawler-status-widget');
    }
}
