<?php

namespace App\Livewire\UserDashboard\Vc;

use App\Models\Tag;
use App\Models\Vc;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class VcDirectory extends Component
{
    use WithPagination, Toast;

    public array $followedVcIds = [];

    public $details = false;

    public $show = false;
    public $search = '';
    public $selectedVerticals = [];
    public $selectedStages = [];

    public $verticalTags = [];

    public $stageTags = [];


    public function toggleFollow(Vc $vc): void
    {


        $user = auth()->user();

        $vcKey = 'follow-vc:' . $user->id . ':' . $vc->id;
        $globalKey = 'follow-vc:global:' . $user->id;

        if (RateLimiter::tooManyAttempts($vcKey, 5)) {
            $this->info('Too fast', 'You are toggling follow on this VC too often. Wait a few seconds.');
            return;
        }

        if (RateLimiter::tooManyAttempts($globalKey, 12)) {
            $this->warning('Rate limited', 'You are following too many VC firms too quickly. Please slow down.');
            return;
        }

        RateLimiter::hit($vcKey, 30);
        RateLimiter::hit($globalKey, 60);

        $isFollowing = DB::table('user_vc_follows')
            ->where('user_id', $user->id)
            ->where('vc_id', $vc->id)
            ->exists();

        if ($isFollowing) {
            $user->followedVCs()->detach($vc->id);
            $this->followedVcIds = array_filter($this->followedVcIds, fn($id) => $id !== $vc->id);
        } else {
            $user->followedVCs()->syncWithoutDetaching([$vc->id]);
            $this->followedVcIds[] = $vc->id;
        }



    }



    public function mount()
    {
        $this->verticalTags = Tag::where('type', 'vertical')
            ->orderBy('name')
            ->get()
            ->map(fn($tag) => [
                'name' => $tag->name,
                'id' => $tag->id,
            ])
            ->toArray();

        $this->stageTags = Tag::where('type', 'stage')
            ->orderBy('name')
            ->get()
            ->map(fn($tag) => [
                'name' => $tag->name,
                'id' => $tag->id,
            ])
            ->toArray();
    }


    public function updatedSearch(): void
    {
        $this->rateLimitCheck();
        $this->resetPage();
    }

    public function updatedSelectedVerticals(): void
    {
        $this->rateLimitCheck();
        $this->resetPage();
    }

    public function updatedSelectedStages(): void
    {
        $this->rateLimitCheck();
        $this->resetPage();
    }

    protected function rateLimitCheck(): void
    {
        $rateLimitKey = 'vc-directory:search:' . auth()->id();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 35)) {
            $this->toast(
                type: 'warning',
                title: 'Hold on',
                description: 'We’re updating your results. Please wait a moment...'
            );

            $this->reset(['search', 'selectedVerticals', 'stageTags']);
            return;

        }

        RateLimiter::hit($rateLimitKey, 30);
    }


    public function render()
    {
        $user = auth()->user();


        $this->followedVcIds = $user->followedVCs()->pluck('vcs.id')->toArray();

        $vcs = Vc::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when(!empty($this->selectedVerticals), fn($q) => $q->whereHas('tags', fn($t) => $t->where('type', 'vertical')->whereIn('tags.id', $this->selectedVerticals)))
            ->when(!empty($this->selectedStages), fn($q) => $q->whereHas('tags', fn($t) => $t->where('type', 'stage')->whereIn('tags.id', $this->selectedStages)))
            ->with('tags')
            ->withCount('newsletters')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.user-dashboard.vc.vc-directory', [
            'vcs' => $vcs,
        ])
            ->layout('components.layouts.user-dashboard')
            ->title('VC Directory');
    }


}
