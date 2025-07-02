<div>
    @if($newsletter && $newsletterViewModal)
        <x-modal
            wire:model="newsletterViewModal"
            title="Newsletter Preview"
            class="backdrop-blur"
            box-class="max-w-5xl p-4"
        >
            {{-- IFRAME Wrapper --}}
            <div class="border border-base-300 rounded-lg overflow-hidden shadow-inner">

                <div x-data="{ loaded: false }" class="relative">
                    {{-- Spinner overlay --}}
                    <div
                        x-show="!loaded"
                        class="absolute inset-0 z-10 flex items-center justify-center bg-base-100/70 backdrop-blur-sm transition-opacity duration-300"
                    >
                        <span class="loading loading-ring loading-lg text-primary"></span>
                    </div>

                    {{-- Iframe --}}
                    <iframe
                        src="{{ route('panel.newsletterView.html', ['id' => $newsletter->id]) }}"
                        class="w-full h-[70vh] bg-white rounded border z-0"
                        sandbox
                        @load="loaded = true"
                    ></iframe>
                </div>



            </div>

            {{-- Footer --}}
            <x-slot:actions>
                <x-button
                    label="Close"
                    icon="o-x-mark"
                    class="btn-sm btn-outline"
                    wire:click="$set('newsletterViewModal', false)"
                />
            </x-slot:actions>
        </x-modal>
    @endif
</div>
