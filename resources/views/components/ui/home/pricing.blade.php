<section
    id="pricing"
    class="py-10 bg-base-100 text-center"
    x-data="{ show: false, hoverBtn: false }"
    x-intersect.once="show = true"
>
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-4xl font-bold mb-8">Pricing Plan</h2>
        <p class="text-base-content/70 mb-12">Choose the plan that fits your needs.</p>

        <!-- Responsive Cards Container -->
        <div class="flex flex-wrap justify-center gap-6">

            @livewire('home.price-plan',['planId' => 1,'label'=>'Basic Plan','labelClass' => 'badge badge-warning text-xs','title' => 'Standard','price' => '$29','per' =>'month'])

            @livewire('home.price-plan',['planId' => 2,'label'=>'Most Popular','labelClass' => 'badge badge-info text-xs','title' => 'Premium','price' => '$69','per' =>'3 month'])

            @livewire('home.price-plan',['planId' => 3,'label'=>'Recommended','labelClass' => 'badge badge-success text-xs','title' => 'Business','price' => '$299','per' =>'year'])


        </div>
    </div>
</section>
