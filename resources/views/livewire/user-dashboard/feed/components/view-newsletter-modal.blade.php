<div>
    @if($newsletterViewModal)
        <x-modal
            wire:model="newsletterViewModal"
            class="backdrop-blur"
            box-class="max-w-6xl rounded-2xl p-0 overflow-hidden bg-base-100 shadow-xl"
        >
            <div class="flex items-center justify-between px-6 py-4 border-b border-base-200 bg-base-100/80 backdrop-blur-sm">
                <h2 class="text-lg font-semibold text-base-content">📬 Newsletter Preview</h2>

            </div>

            <div x-data="{ loaded: false }" class="relative">
                <div
                    x-show="!loaded"
                    class="absolute inset-0 z-10 flex items-center justify-center bg-base-100/70 backdrop-blur-sm transition-opacity duration-300"
                >
                    <span class="loading loading-ring loading-lg text-primary"></span>
                </div>

                <iframe
                    loading="lazy"
                    title="Preview"
                    src="{{ route('panel.newsletterView.html', ['id' => $newsletterId]) }}"
                    class="w-full h-[75vh] bg-white"
                    sandbox="allow-same-origin"
                    @load="loaded = true"
                ></iframe>
            </div>

            <div class="flex justify-end px-6 py-4 border-t border-base-200 bg-base-100/80 backdrop-blur-sm">
                <x-button
                    label="Close"
                    icon="o-x-mark"
                    class="btn-sm btn-outline"
                    wire:click="$set('newsletterViewModal', false)"
                />
            </div>
        </x-modal>
    @endif

</div>
