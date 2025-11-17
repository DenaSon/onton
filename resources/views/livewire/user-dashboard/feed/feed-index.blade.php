<div>
    @include('livewire.user-dashboard.feed._partials.top-menu')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 h-[calc(100vh-8rem)] mt-4">

        {{-- Left: Feed list (scrollable) --}}
        <div
            class="lg:col-span-1 bg-base-100 p-5 border-r border-base-300 overflow-y-auto scroll-slim h-full"
            data-feed-scroll
        >
            <div class="divide-y divide-base-300">
                <div class="divide-y divide-y-[0.5px] divide-base-300" wire:poll.30s>
                    @forelse($newsletters as $newsletter)
                        @php
                            $receivedAt = $newsletter->received_at;
                            $shortTime = '';
                            if ($receivedAt) {
                                $minutes = $receivedAt->diffInMinutes();
                                if ($minutes < 60) {
                                    $shortTime = $minutes . 'min';
                                } elseif ($minutes < 60 * 24) {
                                    $hours = floor($minutes / 60);
                                    $shortTime = $hours . 'h';
                                } elseif ($minutes < 60 * 24 * 30) {
                                    $days = floor($minutes / (60 * 24));
                                    $shortTime = $days . 'd';
                                } else {
                                    $shortTime = $receivedAt->format('M j');
                                }
                            }
                        @endphp

                        <article
                            class="group flex items-center gap-3 p-2 hover:bg-base-200/40 transition rounded-lg cursor-pointer"
                            wire:click="select({{ $newsletter->id }})"
                        >
                            @if($receivedAt)
                                <time
                                    datetime="{{ $receivedAt->toIso8601String() }}"
                                    class="w-12 text-[11px] text-gray-400 tabular-nums text-right"
                                >
                                    {{ $shortTime }}
                                </time>
                            @endif

                            <div class="min-w-0 flex-1">
                                <div class="text-[11px] text-gray-400 truncate">
                                    {{ $newsletter->vc?->name ?? 'VC' }}
                                </div>
                                <h3 class="mt-0 truncate text-sm font-semibold tracking-tight group-hover:text-primary">
                                    {{ $newsletter->subject ?? '—' }}
                                </h3>
                            </div>

                            <button
                                class="shrink-0 opacity-60 hover:opacity-100"
                                wire:click.stop="select({{ $newsletter->id }})"
                                title="Open"
                            >
                                <x-icon name="o-chevron-right" class="w-4 h-4"/>
                            </button>
                        </article>

                    @empty
                        @include('livewire.user-dashboard.feed._partials.empty-mode')
                    @endforelse
                </div>
            </div>

            {{-- Load more button + infinite scroll sentinel --}}
            @if($newsletters->hasMorePages())
                <div
                    class="flex justify-center py-4"
                    data-feed-sentinel
                >
                    <x-button
                        wire:click="loadMore"
                        class="btn-sm btn-outline rounded-lg"
                        label="Load More"
                        spinner
                    ></x-button>
                </div>
            @endif
        </div>

        {{-- Right: Selected content (fixed, scrollable if needed) --}}
        <div
            class="lg:col-span-1 bg-base-100 p-4 rounded-r-2xl overflow-y-auto scroll-slim h-full"
        >
            @if($selected)
                <iframe
                    id="newsletter-frame"
                    class="w-full h-full border-0 rounded-r-2xl"
                    referrerpolicy="no-referrer"
                    srcdoc="{{ $selected->body_html }}"
                    onload="fixIframeLinks()"
                ></iframe>
            @endif
        </div>

    </div>

    <script>
        function fixIframeLinks() {
            const iframe = document.getElementById('newsletter-frame');
            const doc = iframe?.contentDocument || iframe?.contentWindow?.document;

            if (!doc) return;

            const links = doc.querySelectorAll('a');
            links.forEach(link => {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
            });
        }

        function setupInfiniteScroll() {
            const container = document.querySelector('[data-feed-scroll]');
            const sentinel = document.querySelector('[data-feed-sentinel]');

            if (!container || !sentinel) return;


            if (sentinel._observerAttached) return;

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Livewire v3
                            if (window.Livewire && Livewire.dispatch) {
                                Livewire.dispatch('feed-load-more');
                            }
                            // fallback برای v2
                            else if (window.Livewire && Livewire.emit) {
                                Livewire.emit('feed-load-more');
                            }
                        }
                    });
                },
                {
                    root: container,
                    threshold: 1.0, // وقتی sentinel کامل داخل viewport ستون چپ دیده شود
                }
            );

            observer.observe(sentinel);
            sentinel._observerAttached = true;
        }

        document.addEventListener('livewire:load', () => {
            setupInfiniteScroll();
        });

        // برای Livewire 3 و navigate بین کامپوننت‌ها
        document.addEventListener('livewire:navigated', () => {
            setupInfiniteScroll();
        });
    </script>
</div>
