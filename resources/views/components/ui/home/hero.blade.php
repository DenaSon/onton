<section class="bg-base-200 py-20 rounded-2xl backdrop-blur-lg shadow-inner ps-4" id="hero">
    <div class="container mx-auto flex flex-col-reverse md:flex-row items-center justify-between px-4">
        <!-- Left Content -->
        <div class="w-full md:w-1/2 text-center md:text-left">

            <div class="mb-7">

                <h3
                    class="text-3xl md:text-2xl font-bold leading-tight mb-2">
                    Stay Ahead with

                </h3>
                <h1 class="text-primary text-4xl md:text-4xl font-bold">{{config('app.name')}}</h1>

            </div>

            <p class="text-lg md:text-xl text-base-content mb-3">
                Never miss a VC opportunity — Managing all your VC newsletter subscriptions in one place.
                Subscribe or unsubscribe effortlessly without hopping between multiple websites.
            </p>

            <span
                x-data="typewriter(['Track. Analyze. Decide', 'Spot. Learn. Invest'])"
                x-init="start()"
                x-text="text"
                class="block font-semibold font-sans text-primary  md:text-2xl h-10 animate-pulse mb-4"
            ></span>


            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">

                @auth
                    @if(auth()->user()->hasActiveSubscription())
                        <a wire:navigate href="{{ route('panel.index') }}" class="btn btn-primary btn-lg">
                            Dashboard
                        </a>
                    @else
                        @livewire('components.payment.subscribe-button', ['class' => 'btn-primary btn-lg', 'label' => 'Try It Now'])
                    @endif
                @else
                    @livewire('components.payment.subscribe-button', ['class' => 'btn-primary btn-lg', 'label' => 'Try It Now'])
                @endauth

                    <x-button
                        class="btn btn-outline btn-secondary btn-lg"
                        label="Learn More"
                        onclick="document.getElementById('features').scrollIntoView({ behavior: 'smooth' })"
                    />

            </div>

        </div>


        <!-- Right Image -->
        <div class="w-full md:w-1/2 mb-5 md:mb-0 hidden md:block">

            <img
                src="{{ asset('static/img/byblos-hero.webp') }}"
                alt="newsletter automation"
                class="w-full max-w-md mx-auto rounded-2xl shadow-xl ring-1 ring-base-300 hover:scale-105 transition-transform duration-500 ease-in-out"
            />


        </div>

    </div>
</section>
@push('scripts')
    <script src="{{ asset('static/plugins/typewriter.js') }}"></script>
@endpush

