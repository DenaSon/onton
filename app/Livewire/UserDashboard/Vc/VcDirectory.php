<?php

namespace App\Livewire\UserDashboard\Vc;

use App\Models\Vc;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Layout('components.layouts.user-dashboard')]
#[Title('VC Directory')]
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


    public function mount()
    {


        $this->verticalTags = Cache::rememberForever('tags.vertical', function () {
            return \App\Models\Tag::where('type', 'vertical')
                ->orderBy('name')
                ->get()
                ->map(fn($tag) => [
                    'name' => $tag->name,
                    'id' => $tag->id,
                ])
                ->toArray();
        });

        $this->stageTags = Cache::rememberForever('tags.stage', function () {
            return \App\Models\Tag::where('type', 'stage')
                ->orderBy('name')
                ->get()
                ->map(fn($tag) => [
                    'name' => $tag->name,
                    'id' => $tag->id,
                ])
                ->toArray();
        });
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
            ->select('vcs.id', 'vcs.name', 'vcs.logo_url')
            ->when($this->search, fn($q) => $q->where('name', 'like', "{$this->search}%")
            )
            ->when($this->selectedVerticals, fn($q) => $q->withVerticals($this->selectedVerticals)
            )
            ->when($this->selectedStages, fn($q) => $q->withStages($this->selectedStages)

            )
            ->with('tags')
            ->withCount(['newsletters', 'followers'])
            ->orderBy('name')
            ->simplePaginate(20);


        return view('livewire.user-dashboard.vc.vc-directory', [
            'vcs' => $vcs,

        ]);


    }


}
