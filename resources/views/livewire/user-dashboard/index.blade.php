<div>



    @livewire('user-dashboard.overview.welcomeSection')

    <section class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-3" id="newsletterAndBookmarks">

        @livewire('user-dashboard.overview.vcs-widget')

        @livewire('user-dashboard.overview.followed-newsletters-widget')

    </section>
    <hr class="mt-3 text-gray-200 rounded"/>


    @livewire('user-dashboard.overview.quick-access')


    <x-card class="mt-6 bg-base-100 shadow rounded-xl">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <x-heroicon-o-chart-bar class="w-5 h-5 text-secondary" />
                <span class="text-sm font-semibold">Weekly Summary</span>
            </div>
        </x-slot>

        <div class="px-4 py-4 text-sm text-base-content space-y-2">
            <p>
                <strong>5</strong> newsletters were sent to you in the past 7 days.  You bookmarked <strong>9</strong> articles this week.
            </p>
            <p class="text-xs text-gray-500">
                Based on your selected topics and VC preferences.
            </p>
        </div>
    </x-card>




</div>
