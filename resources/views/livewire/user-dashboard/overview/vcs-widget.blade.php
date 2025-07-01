<x-card separator
        class="bg-base-100 shadow-xl rounded-2xl ring-1 ring-base-200 hover:ring-primary/30 transition-all duration-300 group">

    {{-- Header Title --}}
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-heroicon-o-inbox-stack
                class="w-5 h-5 text-primary group-hover:scale-110 transition-transform duration-300"/>
            <span
                class="text-sm font-semibold group-hover:text-primary transition-colors duration-300">Recent VC Firms</span>
        </div>
    </x-slot>

    {{-- Scrollable List Container --}}
    <div class="max-h-72 overflow-y-auto scrollbar-thin scrollbar-thumb-base-300 scrollbar-track-base-200 px-1">
        <ul class="divide-y divide-base-200 text-sm pr-1">
            @foreach($recentVCs as $vc)
                <li class="py-3 px-2 hover:bg-base-200/50 transition duration-200 rounded-md" wire:key="{{$vc->id}}">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-semibold text-base-content group-hover:text-primary transition">
                                {{ $vc->name }}
                            </span>
                            <span class="text-xs text-gray-500 mt-0.5 italic">
                                {{ $vc->newsletters_count }} newsletters
                            </span>
                        </div>

                        @if($vc->latestNewsletter && $vc->latestNewsletter->created_at)
                        <span class="text-xs text-gray-400 whitespace-nowrap">
                             Newsletter received: {{ optional($vc->latestNewsletter)->created_at?->diffForHumans(['short' => true]) ?? '-' }}
                        </span>
                        @endif


                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Footer Link --}}
    <div class="border-t border-base-200 py-4 text-right bg-base-100">
        <a href="{{ route('panel.vc.directory') }}"
           class="text-primary text-xs font-medium hover:underline hover:text-primary/80 transition duration-150 ease-in-out inline-flex items-center gap-1">
            View VC Directory
            <x-icon name="o-arrow-right" class="w-3.5 h-3.5"/>
        </a>
    </div>

</x-card>
