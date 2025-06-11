<?php

namespace App\Livewire\AdminDashboard\VcFirms;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Layout('components.layouts.admin-dashboard')]
class VcsIndex extends Component
{
    use WithPagination,Toast;

    public string $search = '';
    public $page;
    public string $sortBy = 'created_at';
    public $expanded = [];


    public function delete($id): void
    {
        $this->info('VC Deleted Successfully ');
    }



    public function render()
    {
        $fakeData = collect(range(1, 10))->map(function ($i) {
            return (object) [
                'id' => $i,
                'name' => "VC Firm $i",
                'country' => ['United States', 'Germany', 'France', 'Iran'][$i % 4],
                'website' => "https://vcfirm{$i}.com",
                'is_active' => $i % 2 === 0,
                'created_at' => now()->subDays($i),
            ];
        });


        $filtered = $fakeData->filter(function ($item) {
            return str($item->name)->contains($this->search) ||
                str($item->website)->contains($this->search);
        });

        return view('livewire.admin-dashboard.vc-firms.vcs-index', [

            'vcFirms' => $filtered->forPage($this->page, 10)->values(),
        ])->title('VCS Firms');



    }




}
