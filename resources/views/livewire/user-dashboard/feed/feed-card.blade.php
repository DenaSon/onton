<div>

    <x-card
        class="bg-base-100 border border-base-200 shadow-sm hover:shadow-md transition duration-300"
        rounded
    >
        {{-- Header: VC Info --}}
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-3">
                <img src="{{ asset('storage/'.$newsletter->vc->logo_url ?? '/placeholder-logo.svg') }}"
                     alt="{{ $newsletter->vc->name }} Logo"
                     class="w-8 h-8 rounded-full border"/>

                <div class="text-sm font-semibold text-gray-800">
                    {{ $newsletter->vc->name }}
                </div>
            </div>

            <span class="text-xs text-gray-500">
            {{ $newsletter->received_at->diffForHumans() }}
        </span>
        </div>

        {{-- Subject --}}
        <h3 class="text-base font-bold text-gray-900 line-clamp-2 mb-1">
            {{ $newsletter->subject }}
        </h3>

        {{-- Snippet --}}
        <p class="text-sm text-gray-600 line-clamp-3">
            {{ Str::limit(strip_tags($newsletter->body_plain), 200) }}
        </p>

        {{-- Actions --}}
        <div class="flex justify-between items-center mt-4">
            <a href=""
               class="btn btn-xs btn-primary btn-outline">
                View
            </a>

            <div class="flex gap-2 items-center">
                <x-button
                    icon="o-bookmark"
                    class="btn-xs btn-ghost hover:text-primary"
                    title="Bookmark"
                />

                {{-- Future: Share or Save --}}
                {{-- <x-button icon="o-share" class="btn-xs btn-ghost" /> --}}
            </div>
        </div>
    </x-card>


</div>
