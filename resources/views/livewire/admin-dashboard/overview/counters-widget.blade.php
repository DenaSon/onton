<section id="counter">

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body border-l-2 border-primary rounded-sm">


            <div class="stats stats-vertical sm:stats-horizontal w-full gap-2">

                <div class="stat">
                    <div class="stat-figure text-primary">
                        <x-icon name="o-users" class="text-primary h-8 w-8"/>
                    </div>
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value text-primary">{{ number_format($totalUsers) }}</div>
                    <div class="stat-desc">
                        @if(!is_null($growth))
                            @if($growth >= 0)
                                ↑ {{ number_format($growth, 1) }}% this month
                            @else
                                ↓ {{ number_format(abs($growth), 1) }}% this month
                            @endif
                        @else
                            No data for last month
                        @endif
                    </div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-success">
                        <x-icon name="o-user-group" class="text-success h-8 w-8"/>
                    </div>
                    <div class="stat-title">Active Subscriptions This Week</div>
                    <div class="stat-value text-success">{{ number_format($weeklyActiveSubscriptions) }}</div>
                    <div class="stat-desc">
                        @if(!is_null($subscriptionsGrowth))
                            @if($subscriptionsGrowth >= 0)
                                ↗︎ {{ number_format($subscriptionsGrowth, 1) }}% compared to last week
                            @else
                                ↓ {{ number_format(abs($subscriptionsGrowth), 1) }}% compared to last week
                            @endif
                        @else
                            No data for last week
                        @endif
                    </div>
                </div>


                <div class="stat">
                    <div class="stat-figure text-info">
                        <x-icon name="o-envelope-open" class="text-info h-8 w-8"/>
                    </div>
                    <div class="stat-title">Newsletters Crawled</div>
                    <div class="stat-value text-info">{{ number_format($newslettersLast24h) }}</div>
                    <div class="stat-desc">in the last 24 hours</div>
                </div>


                <div class="stat">
                    <div class="stat-figure text-warning">
                        <x-icon name="o-circle-stack" class="text-warning h-8 w-8"/>
                    </div>
                    <div class="stat-title">VC Firms</div>
                    <div class="stat-value text-warning">{{ number_format($vcFirmsTotal) }}</div>
                    <div class="stat-desc">+{{ $vcFirmsThisWeek }} added this week</div>
                </div>


            </div>
        </div>
    </div>


</section>
