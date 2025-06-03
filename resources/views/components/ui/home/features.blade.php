<section class="w-full px-4 md:px-0 my-8" id="features">
    <div class="flex flex-col md:flex-row gap-4 text-center w-full">

        <!-- Feature 1: All-in-One Catalog -->
        <div
            x-data="{ shown: false }"
            x-intersect.once="shown = true"
            class="flex-1 backdrop-blur-lg bg-base-300/60 rounded-2xl p-6 shadow-inner flex flex-col items-center space-y-2 transition-all duration-700 transform"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        >
            <div class="text-primary">
                <x-icon name="o-circle-stack" class="w-8 h-8" />
            </div>
            <div class="text-sm font-medium text-base-content/70">Massive VC Newsletter Catalog</div>
            <div class="text-2xl font-bold text-primary">All In One Place</div>
            <div class="text-sm text-base-content/60">Explore and follow 100+ VC firms with ease</div>
        </div>

        <!-- Feature 2: One-Click Subscribe -->
        <div
            x-data="{ shown: false }"
            x-intersect.once="shown = true"
            class="flex-1 backdrop-blur-lg bg-base-300/60 rounded-2xl p-6 shadow-inner flex flex-col items-center space-y-2 transition-all duration-700 transform delay-200"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        >
            <div class="text-secondary">
                <x-icon name="o-user-plus" class="w-8 h-8" />
            </div>
            <div class="text-sm font-medium text-base-content/70">Quick Subscription</div>
            <div class="text-2xl font-bold text-secondary">One-Click Join</div>
            <div class="text-sm text-base-content/60">No need to visit several websites</div>
        </div>

        <!-- Feature 3: Unsubscribe Anytime -->
        <div
            x-data="{ shown: false }"
            x-intersect.once="shown = true"
            class="flex-1 backdrop-blur-lg bg-base-300/60 rounded-2xl p-6 shadow-inner flex flex-col items-center space-y-2 transition-all duration-700 transform delay-400"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        >
            <div class="text-accent">
                <x-icon name="o-user-minus" class="w-8 h-8" />
            </div>
            <div class="text-sm font-medium text-base-content/70">Unsubscribe Control</div>
            <div class="text-2xl font-bold text-accent">Total Freedom</div>
            <div class="text-sm text-base-content/60">Manage your preferences in one place</div>
        </div>

    </div>
</section>
