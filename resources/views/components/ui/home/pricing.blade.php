@php
    $app_name = config('app.name');
@endphp
<section
        class="bg-base-200/60 backdrop-blur-md py-10 mt-6 border border-primary/10 rounded-3xl ring-1 ring-primary/10 shadow-2xl shadow-primary/10">


    <div class="max-w-6xl mx-auto px-2 grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-24 items-center">

        <!-- Left: Why  -->
        <div class="p-8 max-w-3xl mx-auto space-y-5">
            <div class="space-y-8">
                <h2 class="text-2xl font-extrabold text-primary leading-tight">
                    Why Founders Choose {{ $app_name }} ?
                </h2>
                <div class="w-24 h-1 bg-primary rounded opacity-40"></div>

                <p class="text-base-content/70 text-lg leading-relaxed font-medium">
                    Stay in the VC loop — the smarter way.<br class="hidden sm:inline"/>
                    <span class="text-base-content">
                        {{ $app_name }}  helps you discover, subscribe to, and manage 100+ VC newsletters from one clean, centralized dashboard.
                    </span>
                </p>
            </div>

            <ul class="space-y-4 text-base text-base-content/80">
                <li class="flex items-start gap-3">
                    <x-icon name="o-check-badge" class="w-5 h-5 text-success mt-1"/>
                    <span class="leading-relaxed font-medium">
                        Join <strong>500+ founders</strong> and startup operators
                    </span>
                </li>
                <li class="flex items-start gap-3">
                    <x-icon name="o-check-badge" class="w-5 h-5 text-success mt-1"/>
                    <span class="leading-relaxed font-medium">
                        Covering <strong>100+ VC firms</strong> globally
                    </span>
                </li>
                <li class="flex items-start gap-3">
                    <x-icon name="o-check-badge" class="w-5 h-5 text-success mt-1"/>
                    <span class="leading-relaxed font-medium">
                        No spam, no fluff — just <strong>curated insights</strong>
                    </span>
                </li>
                <li class="flex items-start gap-3">
                    <x-icon name="o-check-badge" class="w-5 h-5 text-success mt-1"/>
                    <span class="leading-relaxed font-medium">
                        One-click <strong>subscribe & unsubscribe</strong>
                    </span>
                </li>
            </ul>
        </div>


        <!-- Right: Plan Card -->
        @livewire('home.price-plan')

    </div>
</section>
