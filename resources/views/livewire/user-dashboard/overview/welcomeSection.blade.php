<div>


    @if($showTrialAlert)
        <x-alert
            icon="o-information-circle"
            title="Free Trial"
            description="{{ $trialMessage }}"
            color="info"
            soft
            shadow
            dismissible
            horizontal
            class="group border border-info/20 hover:shadow-lg transition duration-300 backdrop-blur-sm"
        >
            <div
                class="absolute inset-0 z-0 bg-gradient-to-r from-info/10 to-info/5 blur-xl opacity-50 group-hover:opacity-80 transition duration-500 rounded-xl"></div>

            <x-slot:actions>
                <div class="flex gap-2 z-10">
                    @livewire('components.payment.subscribe-button',['label' => 'Start Trial','class' => 'btn-xs btn-info'])
                </div>
            </x-slot:actions>
        </x-alert>
    @endif


</div>
