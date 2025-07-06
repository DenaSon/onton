<x-card

    rounded
    class="relative border border-gray-300 dark:border-gray-700 bg-base-100 shadow-sm hover:shadow-md transition duration-300 min-h-0 lg:min-h-[220px] pb-14 overflow-hidden group"
>

{{-- Header --}}
    <header class="flex items-center justify-between gap-2 mb-2">
        <div class="flex items-center gap-3">
            <img
                loading="lazy"
                src="{{ $newsletter->vc->logo_url
                    ? asset('storage/' . $newsletter->vc->logo_url)
                    : asset('static/img/vc-no-logo.png') }}"
                alt="{{ $newsletter->vc->name ?? 'VC' }} Logo"
                class="w-9 h-9 rounded-full border border-base-300 shadow-sm"
            />
            <div class="flex flex-col">
                <span class="text-sm font-semibold text-base-content leading-tight">
                    {{ $newsletter->vc->name }}
                </span>
                <span class="text-[11px] text-base-content/50">
                    {{ $newsletter->received_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </header>

    {{-- Subject --}}
    <h3 class="text-base font-semibold text-base-content line-clamp-2 mb-1">

        {{ $newsletter->subject }}
    </h3>

    {{-- Snippet --}}
    <p class="text-sm text-base-content/70 line-clamp-3 mb-3">

        {{ $newsletter->getBodyPreview() }}

    </p>

    {{-- Footer --}}
    <footer
        class="absolute bottom-2 left-0 right-0 px-3 flex justify-between items-center border-t border-base-200 pt-2 bg-gradient-to-t from-base-100 via-base-100/90 to-transparent"
    >
        <x-button
            icon="o-eye"
            class="btn-xs btn-outline btn-ghost text-xs"
            label="View"
            tooltip="Preview"
            x-on:click="$dispatch('newsletterViewModal',  { id: {{ $newsletter->id }} })"
        />

        <x-button
            icon="o-paper-airplane"
            label="Inbox"
            tooltip="Send"
            class="btn-xs btn-ghost text-xs hover:text-primary"
            wire:click.debounce.350ms="$dispatch('sendNewsletter', { id: {{ $newsletter->id }} })"

        />
    </footer>
</x-card>
