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
    use WithPagination,Toast;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];


    public string $search = '';
    public array $expanded = [];

    public int $perPage = 12;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete($id): void
    {
        if (auth()->user()->email !== 'info@byblos.digital') {
            $this->warning('You are not authorized to delete this.');
            return;
        }

        $vc = Vc::findOrFail($id);
        $vc->delete();

        $this->info('VC deleted successfully.');
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
