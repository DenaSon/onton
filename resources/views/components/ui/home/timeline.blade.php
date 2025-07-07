<section class="py-10 bg-base-100" id="how-it-works">
    <div class="max-w-6xl mx-auto px-2 text-center">
        <h2 class="text-4xl font-bold mb-16">How {{ config('app.name') }} Works</h2>

        <div class="relative">
            <!-- Horizontal line -->
            <div class="absolute top-10 left-0 h-1 bg-base-300 z-0 hidden sm:block w-0 animate-grow-x"></div>

            <!-- Timeline steps -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 relative z-10">

                <!-- Step 1 -->
                <div
                    x-data="{ shown: false }"
                    x-intersect.once="shown = true"
                    class="flex flex-col items-center text-center relative transition-all duration-700 transform"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <div class="w-16 h-16 rounded-full bg-primary text-primary-content flex items-center justify-center text-2xl shadow-lg mb-4 z-10">
                        <x-icon name="o-user" class="w-6 h-6" />
                    </div>
                    <h3 class="font-semibold text-lg mb-1">1. Sign Up</h3>
                    <p class="text-sm text-base-content/80">Create an account in seconds.</p>
                </div>

                <!-- Step 2 -->
                <div
                    x-data="{ shown: false }"
                    x-intersect.once="shown = true"
                    class="flex flex-col items-center text-center relative transition-all duration-700 transform delay-200"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <div class="w-16 h-16 rounded-full bg-secondary text-white flex items-center justify-center text-2xl shadow-lg mb-4 z-10">
                        <x-icon name="o-newspaper" class="w-6 h-6" />
                    </div>
                    <h3 class="font-semibold text-lg mb-1">2. Pick Newsletters</h3>
                    <p class="text-sm text-base-content/80">Subscribe to a newsletter that fits your interests</p>
                </div>

                <!-- Step 3 -->
                <div
                    x-data="{ shown: false }"
                    x-intersect.once="shown = true"
                    class="flex flex-col items-center text-center relative transition-all duration-700 transform delay-400"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <div class="w-16 h-16 rounded-full bg-accent text-white flex items-center justify-center text-2xl shadow-lg mb-4 z-10">
                        <x-icon name="o-inbox-arrow-down" class="w-6 h-6" />
                    </div>
                    <h3 class="font-semibold text-lg mb-1">3. Get Content</h3>
                    <p class="text-sm text-base-content/80">Curated VC insights delivered to your inbox.</p>
                </div>

            </div>
        </div>
    </div>
</section>
