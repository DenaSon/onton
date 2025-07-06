<div>

    @if($newsletters->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($newsletters as $newsletter)

                @livewire('user-dashboard.feed.components.feed-card', ['newsletter' => $newsletter], key($newsletter->id))


            @endforeach
        </div>



        <div class="mt-6 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm bg-white dark:bg-base-100">
            {{ $newsletters->links() }}
        </div>


    @else
        <section class="w-full min-h-[100vh] flex flex-col items-center justify-center text-center py-10 px-2">
            <x-icon name="o-rss" class="w-12 h-12 text-base-300 mb-4"/>
            <h3 class="text-2xl font-semibold text-base-content mb-1">No Newsletters Yet</h3>
            <p class="text-sm text-base-content/60 max-w-md mx-auto">
                Once the VC firms you follow publish new newsletters, they'll appear here.
            </p>
            <x-button
                link="{{ route('panel.vc.directory') }}"
                label="Explore VC Directory"
                icon="o-building-library"
                tooltip="Stay in the loop – follow now"
                class="mt-6 btn-primary btn-md shadow-md hover:shadow-lg transition-all duration-200 rounded-xl px-5 py-2.5 text-sm font-semibold tracking-wide"
            />
        </section>
    @endif


    <livewire:user-dashboard.feed.components.view-newsletter-modal
        wire:key="newsletter-modal"
    />


</div>
