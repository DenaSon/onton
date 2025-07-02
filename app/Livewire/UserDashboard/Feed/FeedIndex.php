<?php

namespace App\Livewire\UserDashboard\Feed;

use App\Models\Newsletter;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;



class FeedIndex extends Component
{
    use WithPagination;

    public array $followedVcIds = [];

    public function mount(): void
    {

        $this->followedVcIds = Auth::user()->followedVCs()->pluck('vcs.id')->toArray();
    }

    public function render()
    {
        $newsletters = Newsletter::query()
            ->whereIn('vc_id', $this->followedVcIds)
            ->with('vc:id,name,logo_url')
            ->orderByDesc('received_at')
            ->paginate(1);

        return view('livewire.user-dashboard.feed.feed-index', [
            'newsletters' => $newsletters,
        ])->layout('components.layouts.user-dashboard')->title('Your Feed');
    }
}
