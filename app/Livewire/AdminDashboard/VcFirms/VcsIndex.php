<?php

namespace App\Livewire\AdminDashboard\VcFirms;

use App\Models\Vc;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Layout('components.layouts.admin-dashboard')]
class VcsIndex extends Component
{
    use WithPagination, Toast;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];
    public string $search = '';
    public array $expanded = [];
    public int $perPage = 12;

    public ?string $letter = null; // A-Z or '#'
    public bool $onlyWithoutWhitelist = false; // ✅ فیلتر جدید

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toggleOnlyWithoutWhitelist(): void
    {
        $this->onlyWithoutWhitelist = !$this->onlyWithoutWhitelist;
        $this->resetPage();
    }

    public function setLetter(?string $letter = null): void
    {
        $letter = $letter ? strtoupper($letter) : null;

        if ($letter === null || preg_match('/^[A-Z]$/', $letter) || $letter === '#') {
            $this->letter = $letter;
            $this->resetPage();
        }
    }

    // ...

    public function render()
    {
        $vcFirms = Vc::query()
            ->with([
                'tags',
                'whitelists',
            ])
            ->withCount([
                'newsletters',
            ])
            ->when($this->letter, function ($query) {
                if ($this->letter === '#') {
                    $query->whereRaw("LEFT(name,1) NOT REGEXP '^[A-Za-z]'");
                } else {
                    $query->where('name', 'like', $this->letter . '%');
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "{$this->search}%")
                        ->orWhere('website', 'like', "{$this->search}%");
                });
            })
            ->when($this->onlyWithoutWhitelist, function ($query) {

                $query->whereDoesntHave('whitelists');
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);

        return view('livewire.admin-dashboard.vc-firms.vcs-index', compact('vcFirms'))
            ->title('VC Index');
    }
}
