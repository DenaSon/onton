<x-collapse wire:model="show" separator class="bg-base-100 overflow-visible z-7">
    <x-slot:heading>Search & Filters</x-slot:heading>
    <x-slot:content>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Search Input --}}
            <x-input
                label="Search"
                wire:model.live.debounce.500ms="search"
                placeholder="Search VC Name"
                icon="o-magnifying-glass"
                inline

            />

            {{-- Vertical Tags --}}
            <x-choices-offline
                label="Verticals"
                wire:model.live.350ms="selectedVerticals"
                :options="$verticalTags"
                placeholder="AI, Fintech"
                clearable
                searchable
                inline
                debounce="350ms"
            />

            {{-- Stage Tags --}}
            <x-choices-offline
                label="Stages"
                wire:model.live.350ms="selectedStages"
                :options="$stageTags"
                placeholder="Seed, Series A"
                clearable
                searchable
                inline
                debounce="350ms"
            />


        </div>




    </x-slot:content>
</x-collapse>





