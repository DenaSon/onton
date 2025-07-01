<x-card
    rounded
    class="relative border border-base-200 bg-white backdrop-blur-md shadow-md hover:shadow-lg transition duration-300 min-h-0 lg:min-h-[260px] pb-12"
>
    {{-- Header: VC Info --}}
    <header class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <img src="{{ asset('storage/'.$newsletter?->vc?->logo_url ?? '/placeholder-logo.svg') }}"
                 alt="{{ $newsletter?->vc?->name }} Logo"
                 class="w-8 h-8 rounded-full border"/>

            <div class="text-sm font-semibold text-gray-800">
                {{ $newsletter?->vc?->name }}
            </div>
        </div>

        <span class="text-xs text-gray-500">
            {{ $newsletter?->received_at->diffForHumans() }}
        </span>
    </header>

    {{-- Subject --}}
    <h3 class="text-base font-bold text-gray-900 line-clamp-2 mb-1">
        {{ $newsletter?->subject }}
    </h3>

    {{-- Snippet --}}
    <p class="text-sm text-gray-600 line-clamp-3">
        {{ Str::limit(strip_tags($newsletter?->body_plain), 200) }}
    </p>

    {{-- Fixed Footer --}}
    <footer class="absolute bottom-2 left-0 right-0 px-4 flex justify-between items-center border-t border-t-gray-100">

        <x-button
            icon="o-eye"
            class="btn-xs btn-primary mt-2 btn-outline"
            label="View"
            tooltip="View newsletter"
        />


        <div class="flex gap-2 items-center">
            <x-button
                icon="o-bookmark"
                class="btn-xs btn-ghost hover:text-primary"
                tooltip="Bookmark"
            />
        </div>
    </footer>
</x-card>
