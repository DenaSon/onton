<div>

    <div x-data="{ visible: false }" x-intersect.once="visible = true">
        <template x-if="visible">
            <livewire:admin-dashboard.overview.counters-widget/>
        </template>
    </div>


    <hr class="bg-base-300 mt-2 mb-2 text-base-300"/>

    <div x-data="{ visible: false }" x-intersect.once="visible = true">
        <template x-if="visible">
            <livewire:admin-dashboard.overview.billing-widget/>
        </template>
    </div>




    <hr class="bg-base-300 mt-2 mb-2 text-base-300"/>
    <section class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-3" id="crawler-users-widgets">

        <div x-data="{ visible: false }" x-intersect.once="visible = true">
            <template x-if="visible">
                <livewire:admin-dashboard.overview.users-widget/>
            </template>
        </div>


        <div x-data="{ visible: false }" x-intersect.once="visible = true">
            <template x-if="visible">
                <livewire:admin-dashboard.overview.crawler-status-widget/>
            </template>
        </div>


    </section>


    <hr class="bg-base-300 mt-2 mb-2 text-base-300"/>

    <div x-data="{ visible: false }" x-intersect.once="visible = true">
        <template x-if="visible">
            <livewire:admin-dashboard.overview.health-widget/>
        </template>
    </div>


    <hr class="bg-base-300 mt-2 mb-2 text-base-300"/>


    <div x-data="{ visible: false }" x-intersect.once="visible = true">
        <template x-if="visible">
            <livewire:admin-dashboard.overview.btn-links-widget/>
        </template>
    </div>

</div>
