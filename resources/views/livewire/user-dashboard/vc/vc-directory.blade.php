<div>

    @include('livewire.user-dashboard.vc._partials.search-and-filter')

    <x-card
        title="VC List"
        shadow
        separator
        class="mt-6 bg-base-100 rounded-2xl ring-1 ring-base-200 hover:ring-primary/20 transition-all duration-300 shadow-xl group overflow-hidden z-0">
        @forelse($vcs as $key => $vc)

            <x-list-item :item="$vc" wire:key="{{$vc->id}}">
                <x-slot:avatar>
                    <img
                        src="@if($vc->logo_url !='') {{ asset('storage/'.$vc->logo_url) ?? ''  }} @else {{asset('static/img/vc-no-logo.png')}} @endif"
                        alt="VC Logo" width="10" height="10" class="rounded-full w-10 h-10 border border-primary"/>
                </x-slot:avatar>
                <x-slot:value>
                    {{ $vc->name ?? '' }}  @if($vc->country != null)
                        <span class="badge-xs badge badge-soft">{{ $vc->country }}</span>
                    @endif
                </x-slot:value>
                <x-slot:sub-value>
                    Newsletters : {{ $vc->newsletters_count }}
                </x-slot:sub-value>
                <x-slot:actions>

                    <livewire:user-dashboard.vc.components.follow-unfollow-btn :vc="$vc" :wire:key="'follow-btn-'.$vc->id" />



                </x-slot:actions>
            </x-list-item>

        @empty

            <div class="flex flex-col items-center justify-center py-16 text-center text-sm text-gray-500">
                <x-icon name="o-inbox-stack"
                        class="w-10 h-10 mb-4 text-primary/70 group-hover:scale-105 transition duration-300"/>
                No VC firms to display.

            </div>

        @endforelse


    </x-card>

    @if ($vcs->hasPages())
        <x-card class="mt-6 p-4 shadow-md rounded-box">
            <div class="flex justify-center">
                {{ $vcs->links() }}
            </div>
        </x-card>
    @endif

</div>
