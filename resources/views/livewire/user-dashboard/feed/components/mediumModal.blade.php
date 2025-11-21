<dialog id="my_modal_4" class="modal backdrop-blur-sm bg-black/30">
    <div class="modal-box w-11/12 max-w-5xl
                rounded-2xl shadow-xl
                border border-base-300/60
                bg-base-100/90
                backdrop-blur-md
                animate-fade-in">

        <h3 class="text-xl font-semibold tracking-tight text-base-content/90">
            {{ $selected->vc()->first()->name ?? 'name ' }} Medium article
        </h3>

        <p class="py-4 text-base-content/70 leading-relaxed">


            <x-card

                wire:target="loadMedium"
                class="space-y-3"
            >
                {{-- Loading state --}}
                <div wire:loading wire:target="loadMedium" class="text-sm text-base-content/60">
                    Loading latest Medium posts...
                </div>

                {{-- Loaded state --}}
                <div wire:loading.remove wire:target="loadMedium">
                    @if(empty($mediumItems))
                        <p class="text-sm text-base-content/60">
                            No Medium posts found for this VC.
                        </p>
                    @else
                        <ul class="space-y-3">
                            @foreach($mediumItems as $item)
                                <li class="border border-base-300/70 rounded-xl p-3 hover:border-primary/60 transition">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h4 class="text-sm font-semibold leading-snug line-clamp-2">
                                                {{ $item['title'] ?? 'Untitled article' }}
                                            </h4>

                                            @if(!empty($item['author']))
                                                <p class="mt-1 text-[11px] text-base-content/60">
                                                    by {{ $item['author'] }}
                                                </p>
                                            @endif

                                            @if(!empty($item['pub_date']))
                                                <p class="text-[11px] text-base-content/50">
                                                    {{ $item['pub_date'] }}
                                                </p>
                                            @endif
                                        </div>

                                        @if(!empty($item['link']))
                                            <a
                                                href="{{ $item['link'] }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="btn btn-xs btn-outline shrink-0"
                                            >
                                                Open on Medium
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </x-card>


        </p>

        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-primary btn-sm px-5 rounded-lg shadow-sm
                               hover:shadow-md transition-all duration-200">
                    Close
                </button>
            </form>
        </div>
    </div>
</dialog>
