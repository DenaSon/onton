<div>

    @livewire('admin-dashboard.overview.counters-widget')

    <hr class="bg-base-300 mt-2 mb-2 text-base-300"/>

    @livewire('admin-dashboard.overview.billing-widget')

    <hr class="bg-base-300 mt-2 mb-2 text-base-300"/>

    @livewire('admin-dashboard.overview.health-widget')

    <hr class="bg-base-300 mt-2 mb-2 text-base-300"/>

    <section class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-3" id="crawler-users-widgets">
        @livewire('admin-dashboard.overview.users-widget')

        @livewire('admin-dashboard.overview.crawler-status-widget')
    </section>

    <hr class="bg-base-300 mt-2 mb-2 text-base-300"/>

    @livewire('admin-dashboard.overview.btn-links-widget')


</div>
