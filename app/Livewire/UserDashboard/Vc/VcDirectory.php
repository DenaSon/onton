<?php

namespace App\Livewire\UserDashboard\Vc;

use App\Models\Vc;
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
    public bool $details = false;
    public bool $show = false;

    public string $search = '';
    public ?string $letter = null; // A-Z or '#'

    public function setLetter(?string $letter = null): void
    {
        $letter = $letter ? strtoupper($letter) : null;
        $this->letter = (preg_match('/^[A-Z]$/', $letter) || $letter === '#') ? $letter : null;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->rateLimitCheck();
        $this->resetPage();
    }

    protected function rateLimitCheck(): void
    {
        $key = 'vc-directory:search:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 35)) {
            $this->toast(
                type: 'warning',
                title: 'Hold on',
                description: 'We’re updating your results. Please wait a moment...'
            );
            $this->reset('search');
            return;
        }

        RateLimiter::hit($key, 30);
    }

    public function render()
    {
        $user = auth()->user();
        $this->followedVcIds = $user->followedVCs()->pluck('vcs.id')->toArray();

        $vcs = Vc::query()
            ->select('vcs.id', 'vcs.name', 'vcs.logo_url')
            ->when($this->letter, function ($q) {
                if ($this->letter === '#') {
                    $q->whereRaw("LEFT(name,1) NOT REGEXP '^[A-Za-z]'");
                } else {
                    $q->where('name', 'like', $this->letter . '%');
                }
            })
            ->when($this->search, fn($q) =>
            $q->where('name', 'like', '%' . $this->search . '%')
            )
            ->withCount(['newsletters', 'followers'])
            ->orderBy('name')
            ->paginate(100);

        return view('livewire.user-dashboard.vc.vc-directory', [
            'vcs' => $vcs,
        ]);
    }
}
