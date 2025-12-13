<?php

namespace App\Livewire\AdminDashboard\Crawler;

use App\Models\Whitelist;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class WhitelistIndex extends Component
{
    use WithPagination;
    use Toast;

    public string $search = '';
    public int $perPage = 20;


    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $whitelists = Whitelist::with('vc')
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';

                $query->where(function ($q) use ($term) {
                    $q->where('email', 'like', $term)
                        ->orWhereHas('vc', fn($vc) => $vc->where('name', 'like', $term));
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin-dashboard.crawler.whitelist-index', [
            'whitelists' => $whitelists,
        ]);
    }

    public function delete(int $id): void
    {
        $whitelist = Whitelist::findOrFail($id);
        $whitelist->delete();

        $this->success(
            'Whitelist deleted',
            'The whitelisted email has been removed.'
        );
    }
}
