<x-layouts.admin-dashboard>
    <x-card title="Performance Monitor" separator class="bg-base-200/80">

        <x-slot:subtitle class="float-end">
         <x-ui.global.green-ping/>
        </x-slot:subtitle>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <livewire:pulse.usage cols="3" rows="3" class="mt-3 mb-3"/>
            <livewire:pulse.queues cols="4" class="mt-3 mb-3"/>
            <livewire:pulse.cache cols="4" class="mt-3 mb-3"/>
            <livewire:pulse.slow-queries cols="8" class="mt-3 mb-3"/>
            <livewire:pulse.exceptions cols="6"/>
            <livewire:pulse.slow-requests cols="8" class="mt-3 mb-3"/>
            <livewire:pulse.slow-jobs cols="6"/>
            <livewire:pulse.slow-outgoing-requests cols="6" class="mt-3 mb-3"/>
        </div>
        <livewire:pulse.servers cols="6" class="mb-3 w-full"/>
    </x-card>

</x-layouts.admin-dashboard>
