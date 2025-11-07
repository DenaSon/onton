<x-card class="mb-0 bg-base-200 shadow-sm border border-base-200 rounded-xl">
    <div class="flex flex-col lg:flex-row items-center justify-between gap-4 px-4 py-3">

        <!-- Left: Filter -->
        <div class="flex-shrink-0">
            <x-dropdown label="Filter" class="min-w-[8rem]">
                <x-menu-item title="Filter 1"/>
                <x-menu-item title="Filter 2"/>
                <x-menu-item title="Filter 3"/>
            </x-dropdown>
        </div>

        <!-- Center: Search -->
        <div class="w-full max-w-full flex">

            <x-input
                wire:model.live.debounce.150ms="search"
                label="Search"
                inline
                icon="o-magnifying-glass"
                class="w-full max-w-2xl"
                placeholder="Search newsletters..."
            />



        </div>

        <!-- Right: Promo Banner -->
        <div class="hidden lg:flex justify-end flex-shrink-0">
            <div class="w-[460px] h-20 rounded-2xl overflow-hidden shadow-md border border-base-300 bg-base-200">
                <img src="{{ asset('static/img/banner-placeholder.png') }}"
                     class="w-full h-full object-cover"
                     alt="Promotional banner">
            </div>
        </div>

    </div>
</x-card>
