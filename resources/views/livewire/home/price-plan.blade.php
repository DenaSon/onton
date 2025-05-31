<div
    x-data="{ hoverBtn: false, show: true }"
    id="price-plan-{{ $planId }}"
    class="card w-full sm:w-80 md:w-72 lg:w-80 xl:w-72 bg-base-100 shadow-md transition-all duration-700 ease-out transform border"
    :class="{
        'opacity-100 translate-y-0': show,
        'opacity-0 translate-y-5': !show,
        'border-green-500 shadow-2lg shadow-green-100': hoverBtn,
        'border-primary/20': !hoverBtn
    }"
>
    <div class="card-body items-start">
        <span class="{{ $labelClass ?? '' }}">{{ $label ?? '' }}</span>

        <div class="flex justify-between items-center w-full mt-2">
            <h3 class="text-2xl font-bold">{{ $title ?? '' }}</h3>
            <span class="text-2xl text-primary font-semibold">
                {{ $price ?? '' }} <span class="text-sm text-base-content/60">/{{ $per }}</span>
            </span>
        </div>

        <ul class="mt-6 space-y-2 text-left text-sm">
            <li class="flex items-start gap-2">
                <x-icon name="o-check" class="w-4 h-4 font-bold text-success"/>
                <span>Personalized content curation</span>
            </li>
            <li class="flex items-start gap-2">
                <x-icon name="o-check" class="w-4 h-4 font-bold text-success"/>
                <span>Unlimited newsletter tracking</span>
            </li>
            <li class="flex items-start gap-2">
                <x-icon name="o-check" class="w-4 h-4 font-bold text-success"/>
                <span>Priority delivery scheduling</span>
            </li>
            <li class="flex items-start gap-2 opacity-50 line-through">
                <x-icon name="o-check" class="w-4 h-4 font-bold text-success"/>
                <span>Team collaboration</span>
            </li>
            <li class="flex items-start gap-2 opacity-50 line-through">
                <x-icon name="o-check" class="w-4 h-4 font-bold text-success"/>
                <span>Advanced analytics</span>
            </li>
        </ul>

        <x-button
            spinner
            wire:click="me"
            class="btn-primary w-full mt-6 py-3 text-lg font-semibold rounded-sm shadow-sm hover:shadow-md transition-all duration-100 hover:scale-100"
            label="Start"
            @mouseenter="hoverBtn = true"
            @mouseleave="hoverBtn = false"
        />
    </div>
</div>
