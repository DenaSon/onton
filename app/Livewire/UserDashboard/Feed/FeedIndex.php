<?php

namespace App\Livewire\UserDashboard\Feed;

use App\Models\Newsletter;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;



#[Layout('components.layouts.user-dashboard')]
#[Title('Feed Index')]
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
            ->simplePaginate(18);


        return view('livewire.user-dashboard.feed.feed-index', [
            'newsletters' => $newsletters,
        ]);
    }
}
