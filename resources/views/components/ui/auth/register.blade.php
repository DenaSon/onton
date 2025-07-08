<x-layouts.app title="{{ $title ?? '' }}">

    <div class="hero min-h-screen bg-base-200/80 backdrop-blur-lg rounded-2xl shadow-inner">
        <div class="hero-content flex-col lg:flex-row-reverse gap-8 lg:gap-24 px-4">


            <div
                x-data="{ shown: false }"
                x-intersect.once="shown = true"
                class="flex-1  flex flex-col items-center lg:items-start space-y-4 sm:space-y-6 transition-all duration-500 transform"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
            >
                <img src="{{ asset('static/img/signup-newsletter.svg') }}"
                     alt="SignUp Illustration"
                     class="opacity-90 w-48 sm:w-64 md:w-80 lg:w-full max-w-md rounded-xl  transition-all duration-300" />

                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-extrabold text-primary leading-tight transition-all duration-300">
                    Launch Your Insights

                </h1>

                <p class="text-sm sm:text-base md:text-lg text-base-content/80 max-w-prose text-center lg:text-left">
                    Your time is valuable. We make sure your inbox reflects that.
                </p>
            </div>



            <x-card

                class="w-full max-w-sm bg-base-100/90 shadow-lg rounded-2xl backdrop-blur-md border-primary  transition-shadow duration-100">
                <div class="card-body space-y-0 px-4 py-0">
                    <h2 class="card-title justify-center font-semibold text-2xl text-center animate-pulse">Sign Up</h2>

                    @livewire('auth.register')
                </div>
            </x-card>

        </div>
    </div>


</x-layouts.app>
