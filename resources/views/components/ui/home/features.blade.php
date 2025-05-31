<section class="w-full px-4 md:px-0 my-8" id="features">
    <div class="flex flex-col md:flex-row gap-4 text-center w-full">

        <!-- Feature 1 -->
        <div
            x-data="{ shown: false }"
            x-intersect.once="shown = true"
            class="flex-1 backdrop-blur-lg bg-base-300/60 rounded-2xl p-6 shadow-inner flex flex-col items-center space-y-2 transition-all duration-700 transform"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        >
            <div class="text-primary">
                <x-icon name="o-newspaper" class="w-8 h-8" />
            </div>
            <div class="text-sm font-medium text-base-content/70">Curated VC Content</div>
            <div class="text-2xl font-bold text-primary">Smart Feed</div>
            <div class="text-sm text-base-content/60">Handpicked newsletters from top VCs</div>
        </div>

        <!-- Feature 2 -->
        <div
            x-data="{ shown: false }"
            x-intersect.once="shown = true"
            class="flex-1 backdrop-blur-lg bg-base-300/60 rounded-2xl p-6 shadow-inner flex flex-col items-center space-y-2 transition-all duration-700 transform delay-200"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        >
            <div class="text-secondary">
                <x-icon name="o-tag" class="w-8 h-8" />
            </div>
            <div class="text-sm font-medium text-base-content/70">Interest Tagging</div>
            <div class="text-2xl font-bold text-secondary">+12 Topics</div>
            <div class="text-sm text-base-content/60">Discover by what you care</div>
        </div>

        <!-- Feature 3 -->
        <div
            x-data="{ shown: false }"
            x-intersect.once="shown = true"
            class="flex-1 backdrop-blur-lg bg-base-300/60 rounded-2xl p-6 shadow-inner flex flex-col items-center space-y-2 transition-all duration-700 transform delay-400"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        >
            <div class="text-accent">
                <x-icon name="o-paper-airplane" class="w-8 h-8" />
            </div>
            <div class="text-sm font-medium text-base-content/70">Scheduled Delivery</div>
            <div class="text-2xl font-bold text-accent">Auto-Sent</div>
            <div class="text-sm text-base-content/60">To your inbox or dashboard</div>
        </div>

    </div>




</section>


