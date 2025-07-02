<x-card

    rounded
    class="relative border border-base-200 bg-base-100 backdrop-blur-md shadow-md hover:shadow-lg transition duration-300 min-h-0 lg:min-h-[260px] pb-12"
>

    <header class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <img src="{{ asset('storage/'.$newsletter?->vc?->logo_url ?? '/placeholder-logo.svg') }}"
                 alt="{{ $newsletter?->vc?->name }} Logo"
                 class="w-8 h-8 rounded-full border"/>

            <div class="text-sm font-semibold ">
                {{ $newsletter?->vc?->name }}
            </div>
        </div>

        <span class="text-xs text-gray-500">
            {{ $newsletter?->received_at->diffForHumans() }}
        </span>
    </header>

    {{-- Subject --}}
    <h3 class="text-base font-bold  line-clamp-2 mb-1">
        {{ $newsletter?->subject }}
    </h3>

    {{-- Snippet --}}
    <p class="text-sm text-gray-600 line-clamp-3">
        {{ $this->bodyPreview }}
    </p>

    {{-- Fixed Footer --}}
    <footer class="absolute bottom-2 left-0 right-0 px-2 flex justify-between items-center border-t border-t-gray-100">
        @can('viewHtml', $newsletter)
            <x-button
                icon="o-eye"
                spinner
                class="btn-xs btn-ghoost mt-2 btn-outline hover:text-primary"
                label="View"
                tooltip="View newsletter"
                wire:click.debounce.250ms="view({{$newsletter->id}})"
            />
        @endcan
        <x-button
            icon="o-paper-airplane"
            label="Get in Inbox"
            tooltip="Send"
            class="btn-xs btn-ghost hover:text-primary"
            wire:confirm="Do you want to receive this newsletter in your inbox?"
            wire:click.debounce.350ms="sendNewsletter"
            spinner
        />


    </footer>
</x-card>
