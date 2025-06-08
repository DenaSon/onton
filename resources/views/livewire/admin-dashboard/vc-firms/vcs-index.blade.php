<section class="p-4 bg-base-200 min-h-screen" id="vcFirmsIndex">

    <x-card title="All VC Firms" subtitle="Manage all listed VC firms" separator>

        {{-- Top Filters --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <x-input class="input-sm w-full sm:w-64"
                     inline
                     label="Search"
                     wire:model="search"
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
                ['key' => 'actions', 'label' => 'Actions', 'class' => 'w-32'],
            ];


            $vcFirms = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Sequoia Capital',
                    'country' => 'United States',
                    'website' => 'https://sequoiacap.com',
                    'is_active' => true,
                    'created_at' => '2023-01-10',
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Accel',
                    'country' => 'United Kingdom',
                    'website' => 'https://accel.com',
                    'is_active' => false,
                    'created_at' => '2022-11-05',
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Atomico',
                    'country' => 'Germany',
                    'website' => 'https://atomico.com',
                    'is_active' => true,
                    'created_at' => '2023-03-20',
                ],
            ]);
        @endphp

        {{-- Table --}}
        <x-table
            wire:model="expanded"
            expandable
            :headers="$headers"
            :rows="$vcFirms"


        >

            {{-- Expandable Section --}}
            @scope('expansion', $vcFirm)
            <div class="p-4 text-gray-700">
                <p><strong>Description:</strong> This is expanded info for <em>{{ $vcFirm->name }}</em>.</p>
                <p><strong>Website:</strong> <a href="{{ $vcFirm->website }}" target="_blank" class="link link-primary">{{ $vcFirm->website }}</a></p>
            </div>
            @endscope

            {{-- Status Badge --}}
            @scope('cell_is_active', $vcFirm)
            @if($vcFirm->is_active)
                <x-badge class="badge-success badge-xs" value="Active"/>
            @else
                <x-badge class="badge-warning badge-xs" value="Inactive"/>
            @endif
            @endscope

            {{-- Actions --}}
            @scope('actions', $vcFirm)
            <div class="flex gap-1">
                <x-button
                    icon="o-pencil-square"
                    class="tooltip btn-xs btn-outline btn-info"
                    data-tip="Edit"
                    href="#"
                />
                <x-button
                    wire:click="deactivate({{ $vcFirm->id }})"
                    wire:confirm="Are you sure you want to delete this firm?"
                    icon="o-trash"
                    class="tooltip btn-xs btn-outline btn-warning"
                    data-tip="Delete"
                />
            </div>
            @endscope

        </x-table>

    </x-card>

    <span class="text-xs">
        Pagination will be placed here.like users index
    </span>

</section>
