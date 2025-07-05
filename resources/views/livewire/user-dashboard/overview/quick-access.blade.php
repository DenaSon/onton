<section class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6" id="quickAccess">

    @php
        $cards = [
            ['title' => 'Feed', 'icon' => 'rss','link' => route('panel.feed.index')],
            ['title' => 'VC Directory', 'icon' => 'inbox-stack','link' => route('panel.vc.directory')],
            ['title' => 'Delivery Settings', 'icon' => 'adjustments-horizontal','link' => route('panel.setting.delivery')],
            ['title' => 'My Subscription', 'icon' => 'credit-card','link' => route('panel.payment.management')],
        ];
    @endphp

    @foreach ($cards as $card)
        <a wire:key="quick-card-{{$card['link']}}" href="{{ $card['link'] ?? '#'}}"
           class="group card bg-base-100 border border-base-200 hover:border-primary/60 hover:shadow-xl transition duration-300 rounded-2xl">
            <div class="card-body items-center text-center px-6 py-8 relative overflow-hidden">
                {{-- Background Glow Effect --}}
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-primary/20 to-accent/10 opacity-0 group-hover:opacity-100 blur-2xl transition duration-500 rounded-full z-0"></div>

                {{-- Icon --}}
                <div class="relative z-10">
                    <x-dynamic-component
                        :component="'heroicon-o-' . $card['icon']"
                        class="w-8 h-8 text-primary group-hover:scale-110 transform transition duration-300"
                    />
                    <h3 class="text-sm font-semibold mt-3 group-hover:text-primary transition">{{ $card['title'] }}</h3>
                </div>
            </div>
        </a>
    @endforeach

</section>
