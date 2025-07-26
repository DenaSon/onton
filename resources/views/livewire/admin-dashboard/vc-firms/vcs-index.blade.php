<section class="p-4 bg-base-200 min-h-screen" id="vcFirmsIndex">
    <x-card title="All VC Firms" subtitle="Manage all listed VC firms" separator>

        {{-- Top Filters --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <x-input class="input-sm w-full sm:w-64"
                     inline
                     label="Search"
                     wire:model.live.debounce.100ms="search"
                     placeholder="Search by name or website"
                     icon="o-magnifying-glass"/>
        </div>

        @php
            $headers = [
                ['key' => 'id', 'label' => '#', 'class' => 'w-10'],
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'country', 'label' => 'Country'],
                ['key' => 'website', 'label' => 'Website'],
                ['key' => 'is_active', 'label' => 'Status', 'class' => 'w-20'],
                ['key' => 'created_at', 'label' => 'Created', 'class' => 'w-28'],
                ['key' => 'actions', 'label' => 'Actions', 'class' => 'w-32','sortable'=>false],
            ];
        @endphp

        <x-table
            wire:model="expanded"
            :sort-by="$sortBy"
            expandable
            :headers="$headers"
            :rows="$vcFirms"
            empty-text="No records found."
            empty="No records found."

        >


            {{-- Expandable Section --}}
            @scope('expansion', $vcFirm)

            @include('livewire.admin-dashboard.vc-firms._partials.vc-expansion')

            @endscope

            {{-- Status Badge --}}
            @scope('cell_is_active', $vcFirm)
            @if(optional($vcFirm)->is_active)
                <x-badge class="badge-success badge-xs" value="Active"/>
            @else
                <x-badge class="badge-warning badge-xs" value="Inactive"/>
            @endif
            @endscope

            {{-- Actions --}}
            @scope('actions', $vcFirm)
            <div class="flex gap-1">
                <x-button
                    link="{{ route('core.vc-firms.edit', ['vc'=>$vcFirm->id]) }}"
                    icon="o-pencil-square"
                    class="tooltip btn-xs btn-outline btn-info"
                    data-tip="Edit"
                />
                <x-button
                    wire:click="delete({{ $vcFirm->id }})"
                    wire:confirm="Are you sure you want to delete this VC firm? All related data such as newsletters, whitelist emails, tags, and investment relations will also be permanently deleted."
                    icon="o-trash"
                    class="tooltip btn-xs btn-outline btn-warning"
                    data-tip="Delete"
                />
            </div>
            @endscope

        </x-table>

        <div class="mt-4">
            {{ $vcFirms->links() }}
        </div>

    </x-card>
</section>
