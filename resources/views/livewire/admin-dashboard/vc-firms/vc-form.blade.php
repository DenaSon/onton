<x-card class="space-y-1 max-w-full mx-auto mt-1" separator shadow>
    <x-slot:title>
        <div class="flex items-center gap-2">
            <x-heroicon-o-squares-plus class="w-5 h-5 text-primary"/>
            <span class="text-xl font-semibold">Create New VC </span>
        </div>
    </x-slot:title>

    <x-form wire:submit.prevent="save">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" wire:init="loadCountries">
        <x-input wire:loading.attr="disabled" label="Name"
                 wire:model.defer="name" placeholder="VC Firm Name"/>


        <x-choices-offline
            wire:loading.attr="disabled"
            :options="$countries"
            label="Country"
            wire:model="country"
            option-label="label"
            option-value="code"
            icon="o-globe-americas"
            height="max-h-80"
            placeholder="Select a country..."
            hint="Search and select a country"
            searchable
            clearable
            single

        />

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Upload Logo --}}
        <x-file wire:model="logo" label="VC Logo" hint="Only Images" accept="image/*"/>


        <x-input wire:loading.attr="disabled"  label="Website"
                 wire:model="website" placeholder="500.co">
            <x-slot:prefix>
                <span class="text-sm text-gray-500">https://</span>
            </x-slot:prefix>

        </x-input>
        </div>


        {{-- Description with AI Assist --}}
        <div class="form-control">
            <div class="flex justify-between items-center mb-1">
                <label class="label-text font-semibold">Description</label>
                <x-button
                    spinner
                    data-tip="AI Assist"
                    icon="o-sparkles"
                    class="btn-xs btn-primary tooltip btn-outline rounded-2xl"
                    wire:click="generateDescriptionWithAI"
                />
            </div>

            <x-textarea wire:loading.attr="disabled"
                        wire:model.defer="description"
                        placeholder="Brief description about the VC firm..."
                        rows="3"
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input money label="Ticket Min" wire:model.defer="ticket_min" placeholder="100000" suffix="$" />
            <x-input money label="Ticket Max" wire:model.defer="ticket_max" placeholder="5000000" suffix="$" />
        </div>









        {{-- Section: Tags --}}
        <div class="divider text-sm font-semibold text-base-content/70">Tags</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-choices-offline
            label="Vertical Tags"
            placeholder="Select verticals..."
            wire:model="selectedVerticals"
            :options="$verticalTags"
            option-label="name"
            option-value="id"
            icon="o-tag"
            multiple
            searchable
            clearable
            height="max-h-72"
        />

        <x-choices-offline
            label="Stage Tags"
            placeholder="Select stages..."
            wire:model="selectedStages"
            :options="$stageTags"
            option-label="name"
            option-value="id"
            icon="o-flag"
            multiple
            searchable
            clearable
            height="max-h-72"
        />
        </div>



        <x-choices-offline
            label="This VC invests in"
            placeholder="Select portfolio companies..."
            wire:model="portfolioIds"
            :options="$vcOptions"
            option-label="name"
            option-value="id"
            icon="o-building-office-2"
            multiple
            searchable
            clearable
            height="max-h-72"
        />



        <div class="divider text-sm font-semibold text-base-content/70">VC Whitelist</div>

        <x-tags
            wire:model.defer="whitelistEmails"
            label="Whitelist Emails"
            hint="Hit enter to add multiple emails"
            icon="o-envelope"
            clearable
            placeholder="example@domain.com"
        />



        <div class="text-center mx-auto  mt-2">
            <x-button wire:loading.attr="disabled" wire:target="generateDescriptionWithAI" spinner="save" type="submit"
                      icon="o-check" label="Save" primary class="btn-primary"/>

        </div>


    </x-form>
</x-card>

@push('headScripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>

@endpush
