<x-card class="space-y-1 max-w-3xl mx-auto mt-1" separator shadow>
    <x-slot:title>
        <div class="flex items-center gap-2">
            <x-heroicon-o-squares-plus class="w-5 h-5 text-primary"/>
            <span class="text-sm font-semibold">Create New VC Firm</span>
        </div>
    </x-slot:title>

    <x-form wire:submit.prevent="save">

        {{-- Name --}}
        <x-input wire:loading.attr="disabled" wire:target="generateDescriptionWithAI" label="Name" wire:model.defer="name" placeholder="VC Firm Name"/>


        <div wire:init="loadCountries"></div>
        <span class="text-xs text-primary" wire:loading wire:target="loadCountries">
            Loading Countries...
        </span>
        <x-choices-offline
            wire:loading.attr="disabled" wire:target="generateDescriptionWithAI"
            :options="$countries"
            label="Country"
            wire:model="country"
            option-label="label"
            option-value="label"
            icon="o-globe-americas"
            height="max-h-80"
            placeholder="Select a country..."
            hint="Search and select a country"
            searchable
            clearable
            single
        />


        {{-- Investment Stages --}}
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-2 w-full max-w-md">
            <legend class="fieldset-legend text-base font-semibold">Investment Stages</legend>

            <div class="flex flex-wrap gap-4 mt-2">
                @foreach(['Pre-Seed', 'Seed', 'Series A', 'Series B', 'Growth'] as $stage)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            wire:loading.attr="disabled" wire:target="generateDescriptionWithAI"
                            type="checkbox"
                            wire:model.defer="stages"
                            value="{{ $stage }}"
                            class="checkbox checkbox-sm"
                        />
                        <span class="text-sm">{{ $stage }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>


        <x-input wire:loading.attr="disabled" wire:target="generateDescriptionWithAI" label="Website" wire:model="website" prefix="https://" placeholder="500.co"/>




        {{-- Tags --}}
        <x-tags
            wire:loading.attr="disabled" wire:target="generateDescriptionWithAI"
            label="Tags"
            wire:model="tags"
            icon="o-home"
            hint="Hit enter"
            clearable
        />

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

            <x-textarea wire:loading.attr="disabled" wire:target="generateDescriptionWithAI"
                wire:model.defer="description"
                placeholder="Brief description about the VC firm..."
                rows="3"
            />
        </div>



        {{-- Upload Logo --}}
        <x-file wire:model="logo" label="VC Logo" hint="Only Images" accept="image/*"/>


        <div class="text-center mx-auto  mt-2">
            <x-button wire:loading.attr="disabled" wire:target="generateDescriptionWithAI" spinner="save" type="submit" icon="o-check" label="Save" primary class="btn-primary"/>

        </div>

    </x-form>
</x-card>
