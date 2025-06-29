<div>
    <div x-data="{ hoverBtn: false, show: true }" id="price-plan-basic"
         class="card w-full bg-base-100 shadow-md transition-all duration-700 ease-out transform border"
         :class="{
                    'opacity-100 translate-y-0': show,
                    'opacity-0 translate-y-5': !show,
                    'border-primary shadow-lg shadow-primary/30': hoverBtn,
                    'border-base-300': !hoverBtn
                }">
        <div class="card-body items-start" @mouseenter="hoverBtn = true" @mouseleave="hoverBtn = false">
            <div class="flex justify-between items-center w-full mt-2">
                <h3 class="font-semibold badge badge-info">Free Trial</h3>
                <span class="text-2xl text-primary font-semibold">
                            $0<span class="text-sm text-base-content/60"> / 30 days</span>
                        </span>
            </div>

            <p class="mt-4 text-sm text-base-content/70 font-medium">
                Start with a 30-day free trial. After that, <strong>$9.99/month</strong> unless cancelled.
            </p>

            <ul class="mt-6 space-y-3 text-left text-sm text-base-content/80">
                <li class="flex items-start gap-2">
                    <x-icon name="o-check" class="w-4 h-4 text-success"/>
                    <span>30-day full access</span>
                </li>
                <li class="flex items-start gap-2">
                    <x-icon name="o-check" class="w-4 h-4 text-success"/>
                    <span>Subscribe to 100+ VC newsletters</span>
                </li>
                <li class="flex items-start gap-2">
                    <x-icon name="o-check" class="w-4 h-4 text-success"/>
                    <span>Unlimited newsletter tracking</span>
                </li>
                <li class="flex items-start gap-2">
                    <x-icon name="o-check" class="w-4 h-4 text-success"/>
                    <span>Full content delivery to your inbox</span>
                </li>
                <li class="flex items-start gap-2">
                    <x-icon name="o-check" class="w-4 h-4 text-success"/>
                    <span>Cancel anytime before trial ends</span>
                </li>
            </ul>


            @livewire('components.payment.subscribe-button', [
      'label' => 'Start Free Trial',
      'class' => 'btn-primary w-full mt-6 py-3 text-lg font-semibold rounded-sm shadow-sm hover:shadow-md transition-all duration-100 hover:scale-100',

  ])


        </div>
    </div>


</div>
