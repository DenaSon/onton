<x-form
    wire:submit="saveNewsletterEmail"
    class="flex flex-row sm:flex-row items-start sm:items-center gap-2"
    aria-label="Subscribe form"
>
    {{-- Input --}}
    <x-input
        wire:model="email"
        type="email"
        placeholder="you@example.com"
        label="Email"
        icon="o-envelope"
        class="w-full sm:flex-1"
        inline

    >
        <x-slot:append>

            <x-button
                type="submit"
                class="join-item btn-primary"
                label="Join"
                spinner="saveNewsletterEmail"
            />

        </x-slot:append>

    </x-input>

</x-form>
