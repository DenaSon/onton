<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        @forelse($newsletters as $newsletter)
            <livewire:user-dashboard.feed.feed-card :newsletter="$newsletter" :wire:key="'feed-'.$newsletter->id"/>

            @if($newsletters->hasPages())
                <div class="mt-4">
                    {{ $newsletters->links() }}
                </div>
            @endif

        @empty

            <div class="flex flex-col items-center justify-center py-16 text-center text-base-content/80">

                <x-icon name="o-rss" class="w-10 h-10 text-base-300 mb-3"/>
                <h3 class="text-2xl font-semibold mb-1">No Newsletters Yet</h3>
                <p class="text-sm text-base-content/60">Once the VC firms you follow publish new newsletters, they'll
                    appear
                    here.</p>

                <x-button
                    link="{{ route('panel.vc.directory') }}"
                    label="Explore VC Directory"
                    icon="o-building-library"
                    tooltip="Stay in the loop – follow now"
                    class="mt-5 btn-primary btn-md shadow-md hover:shadow-lg transition-all duration-200 rounded-xl px-4 py-2 text-sm font-semibold tracking-wide"
                />

            </div>

        @endforelse

    </div>


</div>
