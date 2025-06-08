<section class="grid grid-cols-1 xl:grid-cols-1 gap-4 mt-3" id="billingWidget">

    <x-card class="bg-base-100 shadow-md">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <x-heroicon-o-credit-card class="w-5 h-5 text-primary" />
                <span class="text-sm font-semibold">Subscription & Billing Overview</span>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="stat">
                <div class="stat-title text-xs">Active Subscriptions</div>
                <div class="stat-value text-primary">128</div>
            </div>
            <div class="stat">
                <div class="stat-title text-xs">Monthly Revenue</div>
                <div class="stat-value text-success">$2,540</div>
            </div>
            <div class="stat">
                <div class="stat-title text-xs">Cancelled Subscriptions</div>
                <div class="stat-value text-error">12</div>
            </div>
            <div class="stat">
                <div class="stat-title text-xs">Last Payment</div>
                <div class="stat-value text-gray-500">2 days ago</div>
            </div>
        </div>

    </x-card>

</section>
