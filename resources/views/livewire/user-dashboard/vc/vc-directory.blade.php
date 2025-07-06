<div>

    @include('livewire.user-dashboard.vc._partials.search-and-filter')

    <x-card
        title="VC List"
        shadow
        separator
        progress-indicator
        class="mt-6 bg-base-100 rounded-2xl ring-1 ring-base-200 hover:ring-primary/20 transition-all duration-300 shadow-xl group overflow-hidden z-0"
    >
        @forelse($vcs as $key => $vc)

            <x-list-item :item="$vc" wire:key="vcwk-{{ $vc->id }}">
                <x-slot:avatar>
                    <img
                        src="{{ $vc->logo_url ? asset('storage/' . $vc->logo_url) : asset('static/img/vc-no-logo.png') }}"
                        alt="{{ $vc->name }} Logo"
                        class="rounded-full w-12 h-12 border border-primary shadow-sm object-cover"
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
                <x-icon name="o-inbox-stack"
                        class="w-10 h-10 mb-4 text-primary/70 group-hover:scale-105 transition duration-300" />
                No VC firms to display.
            </div>
        @endforelse
    </x-card>


    @if ($vcs->hasPages())
        <x-card class="mt-6 p-4 shadow-lg rounded-box">

                {{ $vcs->links() }}

        </x-card>
    @endif

</div>
