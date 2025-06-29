<?php

namespace App\Livewire\AdminDashboard\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Layout('components.layouts.admin-dashboard')]
class UserIndex extends Component
{
    use Toast, WithPagination;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'asc'];
    public array $expanded = [];
    #[Validate('string|in:suspended,active')]
    public string $filter = '';
    #[Validate('string|max:100')]
    public string $search = '';

    public function mount()
    {
        $this->filter = request()->query('filter', '');
    }

    public function updatedFilter()
    {
        $this->filter = in_array(request()->query('filter'), ['suspended', 'active'])
            ? request()->query('filter')
            : '';

        $this->resetPage();
    }

    public function suspendUser(User $user)
    {
        try {
            $id = $user->id;

            $user = User::findOrFail($id);
            $user->update(['is_suspended' => true]);
            $this->info('User has been suspended', '');
        } catch (\Exception $e) {
            $this->info('cannot suspend user', $e->getMessage());
        }
    }


    public function active(User $user)
    {
        try {
            $id = $user->id;

            $user = User::findOrFail($id);
            $user->update(['is_suspended' => false]);
            $this->info('User has been activated', '');
        } catch (\Exception $e) {
            $this->info('cannot active user', $e->getMessage());
        }
    }


    public function render()
    {

        $users = User::query()
            ->when($this->filter === 'suspended', fn($q) => $q->where('is_suspended', true))
            ->when($this->search !== '' && strlen($this->search) > 4, function ($q) {
                $q->where(function ($query) {
                    $this->resetPage();
                    $query->where('email', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy(...array_values($this->sortBy))
            ->with('subscriptions')
            ->paginate(10);


        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'w-12'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'is_suspended', 'label' => 'Status', 'class' => 'w-12'],
            ['key' => 'created_at', 'label' => 'Registered'],
            ['key' => 'trial_ends_at', 'label' => 'Trial Ends'],
            ['key' => 'actions', 'label' => 'Actions', 'class' => 'w-32', 'sortable' => false],
        ];

        return view('livewire.admin-dashboard.users.user-index', compact('users', 'headers'))->title('Users Management');
    }
}
