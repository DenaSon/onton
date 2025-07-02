<div>



    @include('livewire.user-dashboard.overview.welcomeSection')

    <section class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-3" id="newsletterAndBookmarks">

        @livewire('user-dashboard.overview.vcs-widget')

        @livewire('user-dashboard.overview.followed-newsletters-widget')

    </section>
    <hr class="mt-3 text-gray-200 rounded"/>


    @livewire('user-dashboard.overview.quick-access')


        @include('livewire.user-dashboard.overview.summary')




</div>
