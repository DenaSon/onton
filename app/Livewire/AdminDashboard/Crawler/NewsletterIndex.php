<?php

namespace App\Livewire\AdminDashboard\Crawler;

use App\Models\Newsletter;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-dashboard')]

class NewsletterIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';



    public function render()
    {
        $newsletters = Newsletter::query()
            ->with(['vc' => fn ($q) => $q->select('id', 'name')->withCount('newsletters')])
            ->select(['id', 'vc_id', 'from_email', 'subject', 'received_at'])
            ->latest('received_at')
            ->paginate(15);

        return view('livewire.admin-dashboard.crawler.newsletter-index', compact('newsletters'));
    }
}
