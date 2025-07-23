<?php

namespace App\Livewire\AdminDashboard\VcFirms;

use App\Models\Vc;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-dashboard')]
class VcsIndex extends Component
{
    use WithPagination;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'asc'];


    public string $search = '';
    public array $expanded = [];

    public int $perPage = 12;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $vc = Vc::findOrFail($id);
        $vc->delete();
    }

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
            ->when($this->search, fn($query) =>
            $query->where('name', 'like', "{$this->search}%")
                ->orWhere('website', 'like', "{$this->search}%")
            )
           // ->orderByDesc('created_at')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);

        return view('livewire.admin-dashboard.vc-firms.vcs-index', compact('vcFirms'))
            ->title('VC Index');
    }
}
