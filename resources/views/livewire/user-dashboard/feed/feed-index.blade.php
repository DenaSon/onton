<div class="grid grid-cols-1 lg:grid-cols-3 gap-0">

    <div class="col-span-2 bg-base-100 p-5 border-r border-base-300">

        <div class="divide-y divide-base-300">
            @foreach($newsletters as $newsletter)
                <article
                    class="group flex items-start gap-3 p-3 hover:bg-base-200/70 transition rounded-lg cursor-pointer"
                    wire:click="select({{ $newsletter->id }})"
                >



                    {{-- Main --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 text-xs opacity-70">
                            <span class="truncate max-w-[10rem]">{{ $newsletter->vc?->name ?? 'VC' }}</span>
                            <span>•</span>
                            <time datetime="{{ optional($newsletter->received_at)->toIso8601String() }}">
                                {{ optional($newsletter->received_at)->diffForHumans() }}
                            </time>
                        </div>

                        <h3 class="mt-0.5 truncate font-medium group-hover:text-primary">
                            {{ $newsletter->subject ?? '—' }}
                        </h3>

                    </div>

                    <button class="shrink-0 ml-2 opacity-60 hover:opacity-100" wire:click.stop="select({{ $newsletter->id }})" title="Open">
                        <x-icon name="o-chevron-right" class="w-4 h-4"/>
                    </button>
                </article>
            @endforeach
        </div>




    </div>



    <div class="col-span-1 bg-base-100 p-4 overflow-y-auto rounded-r-2xl">


    </div>



</div>
