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

    public string $search = '';
    public array $expanded = [1];

    public int $perPage = 10;

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
            ->when($this->search, fn($query) =>
            $query->where('name', 'like', "%{$this->search}%")
                ->orWhere('website', 'like', "%{$this->search}%")
            )
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.admin-dashboard.vc-firms.vcs-index', compact('vcFirms'))
            ->title('VC Index');
    }
}
