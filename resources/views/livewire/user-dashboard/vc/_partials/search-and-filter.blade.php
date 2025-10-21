{{-- Simple search (no accordion, name-only) --}}
<div class="bg-base-100">
    <x-input
        wire:model.live.debounce.400ms="search"
        placeholder="Search VC by name"
        icon="o-magnifying-glass"
        inline
    />
</div>
