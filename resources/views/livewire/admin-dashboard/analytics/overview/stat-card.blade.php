<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <x-stat
        title="Total Active Users"
        :value="$activeUsers"
        icon="o-users"
        tooltip-bottom="All non-suspended users"
        color="text-success" />

    <x-stat
        title="Trial Users"
        :value="$trialUsers"
        icon="o-user"
        tooltip-bottom="Users currently in trial period"
        color="text-warning" />

    <x-stat
        title="New Active Subscriptions Today"
        :value="$activeToday"
        icon="o-sparkles"
        tooltip-bottom="Users who started active subscriptions today"
        color="text-info" />

</div>
