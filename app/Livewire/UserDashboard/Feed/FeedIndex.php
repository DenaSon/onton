<?php

namespace App\Livewire\UserDashboard\Feed;

use App\Models\Newsletter;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.user-dashboard')]
#[Title('Feed Index')]
class FeedIndex extends Component
{
    Use Toast;
    public array $followedVcIds = [];
    public int $perPage = 20;
    public ?int $selectedId = null;
    public ?Newsletter $selected = null;

    public string $search = '';

    public string $filter = 'all';


    public function mount(): void
    {
        $this->followedVcIds = Auth::user()->followedVCs()->pluck('vcs.id')->toArray();


        $latest = Newsletter::latest()->select('id')->first();


        if ($latest) {
            $this->select($latest->id);
        }
    }



    public function select(int $id): void
    {

        $base = Newsletter::query()

            ->where('id', $id);


        $this->selected = $base
            ->select(['id','vc_id','subject','received_at','body_plain','body_html'])
            ->with(['vc:id,name,logo_url'])
            ->firstOrFail();

        $this->selectedId = $this->selected->id;
    }

    #[On('feed-load-more')]
    public function loadMore(): void
    {
        $this->perPage += 40;
    }

    public function render()
    {
        $newsletters = Newsletter::query()
            ->when($this->filter === 'substack', function ($q) {
                $q->where('from_email', 'like', '%@substack.com');
            })
            ->when($this->filter === 'medium', function ($q) {
                $q->where('from_email', 'like', '%@medium.com');
            })
            ->when($this->filter === 'all', function ($q) {

            })
            ->when($this->search, function ($query) {
                $query->where('subject', 'like', '%' . $this->search . '%');
            })
            ->select(['id', 'vc_id', 'subject', 'received_at'])
            ->with(['vc:id,name,logo_url'])
            ->orderByDesc('received_at')
            ->simplePaginate($this->perPage);

        return view('livewire.user-dashboard.feed.feed-index', [
            'newsletters' => $newsletters,
        ]);
    }

}
