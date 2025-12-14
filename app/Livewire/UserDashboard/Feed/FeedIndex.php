<?php

namespace App\Livewire\UserDashboard\Feed;

use App\Models\Newsletter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Log;
use Mary\Traits\Toast;

#[Layout('components.layouts.app')]
#[Title('VC Newsletter Aggregator')]
class FeedIndex extends Component
{
    use Toast;

    public array $followedVcIds = [];
    public int $perPage = 20;
    public ?int $selectedId = null;
    public ?Newsletter $selected = null;

    public string $search = '';

    public string $filter = 'all';


    public array $mediumItems = [];


    public function mount(): void
    {
        // $this->followedVcIds = Auth::user()->followedVCs()->pluck('vcs.id')->toArray();


        $latest = Newsletter::latest()->select('id')->first();

        if ($latest) {
            $this->select($latest->id);
        }
    }


    public function showMediumModal($newsletterId): void
    {
        $newsletter = Newsletter::select('id', 'vc_id')
            ->with(['vc:id,medium_url'])
            ->findOrFail($newsletterId);

        $mediumUsername = $newsletter->vc->medium_url;

        $this->dispatch('openMediumModal', $mediumUsername);
    }


    public function select(int $id): void
    {

        $base = Newsletter::query()
            ->where('id', $id);


        $this->selected = $base
            ->select(['id', 'vc_id', 'subject', 'received_at', 'body_plain', 'body_html'])
            ->with(['vc:id,name,logo_url'])
            ->firstOrFail();

        $this->selectedId = $this->selected->id;
    }

    #[On('feed-load-more')]
    public function loadMore(): void
    {
        $this->perPage += 40;
    }

    public function loadMedium(): void
    {


        if (!$this->selected?->vc?->medium_feed_url) {
            $this->mediumItems = [];
            return;
        }

        try {
            $rss = app(\App\Services\Crawler\Rss2JsonService::class);

            $result = $rss->fetch($this->selected->vc->medium_feed_url, [
                'order_by' => 'pubDate',
                'order_dir' => 'desc',
                'count' => 10,
            ]);

            $this->mediumItems = $result['items'] ?? [];
        } catch (\Throwable $e) {
            Log::warning('Medium RSS load failed', [
                'vc' => $this->selected->vc->id ?? null,
                'error' => $e->getMessage(),
            ]);

            $this->mediumItems = [];
        }
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
                // no-op
            })
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', $search)
                        ->orWhereHas('vc', function ($vc) use ($search) {
                            $vc->where('name', 'like', $search);
                        });
                });
            })
            ->select('*')
            ->with(['vc'])
            ->orderByDesc('received_at')
            ->simplePaginate($this->perPage);

        return view('livewire.user-dashboard.feed.feed-index', [
            'newsletters' => $newsletters,
        ]);
    }


}
