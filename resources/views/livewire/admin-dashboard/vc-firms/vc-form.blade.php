<x-card class="space-y-1 max-w-full mx-auto mt-1" separator shadow>
    <x-slot:title>
        <div class="flex items-center gap-2">
            <x-heroicon-o-squares-plus class="w-5 h-5 text-primary"/>
            <span class="text-xl font-semibold">Create New VC </span>
        </div>
    </x-slot:title>

    <x-form wire:submit.prevent="save" wire:target="loadCountries">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <x-input wire:loading.attr="disabled" label="Name"
                     wire:model.defer="name" placeholder="VC Firm Name"/>

            <x-choices-offline
                wire:loading.attr="disabled"
                :options="$countries"
                label="Country (optional)"
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
            <x-file wire:model="logo" label="VC Logo" hint="Only Images" accept="image/*"/>


            <x-input wire:loading.attr="disabled" label="Website"
                     wire:model="website" placeholder="500.co">
                <x-slot:prefix>
                    <span class="text-sm text-gray-500">https://</span>
                </x-slot:prefix>
            </x-input>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input wire:model.defer="substack_url" label="Substack URL (optional)" placeholder="substack.com/@vcname">
                <x-slot:prefix><span class="text-sm text-gray-500">https://</span></x-slot:prefix>
            </x-input>

            <x-input wire:model.defer="medium_url" label="Medium URL (optional)" placeholder="medium.com/@vcname">
                <x-slot:prefix><span class="text-sm text-gray-500">https://</span></x-slot:prefix>
            </x-input>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input wire:model.defer="blog_url" label="Blog URL (optional)" placeholder="blog.vc.com">
                <x-slot:prefix><span class="text-sm text-gray-500">https://</span></x-slot:prefix>
            </x-input>
        </div>

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

        {{-- Portfolio --}}
        <x-choices-offline
            label="Portfolio"
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

        {{-- X Accounts --}}
        <div class="divider text-sm font-semibold text-base-content/70">X Accounts</div>

        <x-tags
            wire:model.defer="official_x_accounts"
            label="Official X Accounts"
            hint="Add multiple usernames (@vcname)"
            icon="o-hashtag"
            clearable
            placeholder="@vc_official"
        />

        <x-tags
            wire:model.defer="staff_x_accounts"
            label="Staff X Accounts"
            hint="Add multiple usernames"
            icon="o-user"
            clearable
            placeholder="@staffname"
        />

        {{-- Whitelist --}}
        <div class="divider text-sm font-semibold text-base-content/70">VC Whitelist</div>
        <x-tags
            wire:model.defer="whitelistEmails"
            label="Whitelist Emails"
            hint="Hit enter to add multiple emails"
            icon="o-envelope"
            clearable
            placeholder="example@domain.com"
        />

        <div class="text-center mx-auto mt-2">
            <x-button wire:loading.attr="disabled" spinner="save" type="submit"
                      icon="o-check" label="Save" primary class="btn-primary"/>
        </div>
    </x-form>
</x-card>
