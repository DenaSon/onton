<x-card separator class="bg-base-100 shadow-xl rounded-2xl ring-1 ring-base-200 hover:ring-primary/30 transition-all duration-300 max-w-full overflow-hidden group">

    {{-- Header Title --}}
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-heroicon-o-star class="w-5 h-5 text-primary group-hover:scale-110 transition-transform duration-300"/>
            <span class="text-sm font-semibold group-hover:text-primary transition-colors duration-300">Followed Newsletters</span>
        </div>
    </x-slot>

    {{-- Scrollable Followed Newsletters List --}}
    <div class="px-4 py-2 max-h-72 overflow-y-auto scrollbar-thin scrollbar-thumb-base-300 scrollbar-track-base-200 space-y-4 pr-1">

        @forelse($newsletters as $newsletter)
            <div wire:key="newsletter-follow-{{$newsletter->id}}" class="p-3 rounded-lg bg-base-200/40 hover:bg-base-300/40 transition-colors duration-200 border border-transparent hover:border-primary/30">
                <p class="flex justify-between items-center text-sm font-medium text-base-content" title="{{ $newsletter->subject }}">
                    <span class="text-xs text-gray-400 order-2">{{ $newsletter->vc->name ?? '' }}</span>
                    <span class="order-1">{{ \Illuminate\Support\Str::limit($newsletter->subject, 50) }}</span>
                </p>

                <p class="text-xs text-gray-500 mt-1">
                    From: {{ $newsletter->from_email }} &bull;
                    Received: {{ $newsletter->received_at?->diffForHumans() ?? '-' }}
                </p>
            </div>
        @empty
            <div class="text-sm text-gray-500 py-8 text-center">
                <x-icon name="o-information-circle" class="inline w-4 h-4 mr-1 text-info"/>
                You haven’t followed any newsletters yet.
            </div>
        @endforelse

    </div>

    @if($newsletters->count() > 10)
        {{-- Footer --}}
        <div class="border-t border-base-200 py-4 text-right bg-base-100">
            <a href="{{ route('panel.feed.index') }}" wire:navigate.hover
               class="text-primary text-xs font-medium hover:underline hover:text-primary/80 transition duration-150 ease-in-out inline-flex items-center gap-1">
                View All Followed Newsletters
                <x-icon name="o-arrow-right" class="w-3.5 h-3.5"/>
            </a>
        </div>
    @endif

</x-card>
