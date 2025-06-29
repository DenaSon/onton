<section class="p-4 bg-base-200 min-h-screen" id="usersIndex">

    <x-card title="All Users" subtitle="Manage all registered users" separator progress-indicator>

        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <x-input class="input-sm w-full sm:w-64" inline label="Search" wire:model.live.debounce.350ms="search"
                     placeholder="Search by name and email" icon="o-magnifying-glass"/>
        </div>


        <x-table empty-text="No Records" empty="The list is empty" wire:model="expanded" expandable :headers="$headers"
                 :rows="$users" :sort-by="$sortBy" with-pagination>


            @scope('expansion', $user)
            <div class="">
                @include('livewire.admin-dashboard.users._partials.user-expansion')
            </div>
            @endscope


            @scope('actions', $user)
            <div class="flex">

                @if(!$user->is_suspended)
                    <x-button spinner wire:click="suspendUser('{{ $user->id }}')"
                              wire:confirm="Are you sure you want to suspend this user?" responsive icon="o-lock-closed"
                              class="tooltip btn-xs btn-outline btn-warning" data-tip="Suspend"/>
                @else
                    <x-button spinner wire:click="active('{{ $user->id }}')"
                              wire:confirm="Are you sure you want to active this user?" responsive icon="o-check"
                              class="tooltip btn-xs btn-outline btn-success" data-tip="Active"/>
                @endif

            </div>
            @endscope



            @scope('cell_is_suspended', $user)
            @if($user->is_suspended)
                <x-badge class="badge-warning badge-xs" value="Suspended"/>
            @else
                <x-badge class="badge-success badge-xs" value="Active"/>
            @endif
            @endscope

        </x-table>

    </x-card>


</section>
