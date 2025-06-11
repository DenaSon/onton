@push('headScripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush
<div>


    <div x-data="{ visible: false }" x-intersect.once="visible = true">
        <template x-if="visible">
            <livewire:admin-dashboard.analytics.overview.stat-card/>
        </template>
    </div>

    <div x-data="{ visible: false }" x-intersect.once="visible = true">
        <template x-if="visible">
            <livewire:admin-dashboard.analytics.overview.active-user-chart/>
        </template>
    </div>

    <div x-data="{ visible: false }" x-intersect.once="visible = true">
        <template x-if="visible">
            <livewire:admin-dashboard.analytics.overview.trial-vs-paid-chart/>
        </template>
    </div>
</div>
