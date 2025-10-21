<div>
    {{-- Search (as-is) --}}
    @include('livewire.user-dashboard.vc._partials.search-and-filter')

    {{-- Alphabet bar (server-side) --}}
    <div class="mt-4 flex items-center gap-1 overflow-x-auto border-y border-base-200 py-2 px-3 bg-base-100 rounded-xl">
{{--        wire:click="setLetter(null)"--}}
        <button
            class="px-2 text-sm font-semibold rounded hover:text-primary focus:outline-none cursor-pointer"
            @class([
                'text-primary underline' => empty($letter),
                'opacity-80' => !empty($letter),
            ])
        >All</button>
{{--        wire:click="setLetter('#')"--}}
        <button

            class="px-2 text-sm font-semibold rounded hover:text-primary focus:outline-none cursor-pointer"
            @class([
                'text-primary underline' => ($letter === '#'),
                'opacity-80' => ($letter !== '#'),
            ])
        >#</button>

        @foreach(range('A','Z') as $L)
{{--            wire:click="setLetter('{{ $L }}')"--}}
            <button

                class="px-2 text-sm font-semibold rounded hover:text-primary focus:outline-none cursor-pointer"
                @class([
                    'text-primary underline' => ($letter === $L),
                    'opacity-80' => ($letter !== $L),
                ])
            >{{ $L }}</button>
        @endforeach
    </div>

    {{-- Optional: status line --}}
    <div class="mt-2 text-xs text-base-content/60">
        Showing: <span class="font-semibold">{{ $letter ?: 'All' }}</span>
        @if($search) · Search: “{{ $search }}” @endif
    </div>

    {{-- VC list (no client grouping; server-side filters handle letter) --}}
    <x-card
        title="VC List"
        shadow
        separator
        progress-indicator
        class="mt-3 bg-base-100 rounded-2xl ring-1 ring-base-200 hover:ring-primary/20 transition-all duration-300 shadow-xl group overflow-hidden z-0"
    >
        @forelse($vcs as $vc)
            <x-list-item :item="$vc" wire:key="vcwk-{{ $vc->id }}">
                <x-slot:avatar>
                    <img
                        src="{{ $vc->logo_url ? asset('storage/' . $vc->logo_url) : asset('static/img/no-vc-placeholder.png') }}"
                        alt="{{ $vc->name }} Logo"
                        class="rounded-full w-12 h-12 border border-primary shadow-sm object-cover"
                        loading="lazy"
                    />
                </x-slot:avatar>

                <x-slot:value>
                    <div class="flex items-center gap-2 text-base font-semibold text-base-content">
                        {{ $vc->name }}
                        @if ($vc->newsletters_count)
                            <span class="hidden sm:inline text-xs badge badge-ghost border border-gray-300">
                                <x-icon name="o-envelope" class="w-4 h-4 mr-1 text-gray-500" />
                                {{ $vc->newsletters_count }}
                            </span>
                        @endif
                    </div>
                </x-slot:value>

                <x-slot:sub-value>
                    <div class="flex items-center text-sm text-gray-500 gap-2">
                        @if ($vc->followers_count)
                            <x-icon name="o-user-group" class="w-4 h-4 text-primary" />
                            <span>{{ $vc->followers_count }} followers</span>
                        @endif
                    </div>
                </x-slot:sub-value>

                <x-slot:actions>
                    <livewire:user-dashboard.vc.components.follow-unfollow-btn
                        :vc="$vc"
                        :followedVcIds="$this->followedVcIds"
                        :wire:key="'follow-btn-' . $vc->id"
                    />
                </x-slot:actions>
            </x-list-item>
        @empty
            <div class="flex flex-col items-center justify-center py-16 text-center text-sm text-gray-500">
                <x-icon name="o-inbox-stack" class="w-10 h-10 mb-4 text-primary/70 group-hover:scale-105 transition duration-300" />
                No VC firms to display.
            </div>
        @endforelse
    </x-card>

    {{-- Server-side paging per selected letter --}}
    @if ($vcs->hasPages())
{{--        <x-card class="mt-4 p-3 rounded-box">--}}
{{--            {{ $vcs->links() }}--}}
{{--        </x-card>--}}
    @endif
</div>
