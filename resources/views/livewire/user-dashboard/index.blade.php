<div>


    @include('livewire.user-dashboard.overview.welcomeSection')


    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mt-3" id="newsletterAndBookmarks">

        @livewire('user-dashboard.overview.followed-newsletters-widget')

        @livewire('user-dashboard.overview.followed-substack-widget')

        @livewire('user-dashboard.overview.followed-medium-widget')

    </section>


    <hr class="mt-3 text-gray-200 rounded"/>





    @include('livewire.user-dashboard.overview.summary')


    @livewire('user-dashboard.overview.quick-access')

</div>
