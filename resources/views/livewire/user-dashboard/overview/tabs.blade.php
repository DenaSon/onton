{{-- Unified Aggregated Feed – clean centered Mary-UI tabs --}}

<x-card class="mt-6 p-6 bg-base-100 rounded-2xl shadow-lg border border-base-200">
    <div class="flex justify-center">
        <div class="w-full max-w-6xl">
            <x-tabs
                wire:model="tabSelected"
                active-class="bg-primary text-white rounded-lg"
                label-class="font-semibold"
                label-div-class="bg-base-200/70 rounded-lg w-fit p-1 mx-auto flex flex-wrap justify-center gap-2"
            >
                <x-tab name="all-feed" label="All feed">
                    <div class="py-6 text-center text-sm opacity-70">
                        {{-- Content will be loaded later (all aggregated feed) --}}
                        <span>



                        </span>
                    </div>
                </x-tab>

                <x-tab name="email-newsletters" label="Email Newsletters">
                    <div class="py-6 text-center text-sm opacity-70">
                        <span>Email newsletters will appear here.</span>
                    </div>
                </x-tab>

                <x-tab name="substack" label="Substack newsletter">
                    <div class="py-6 text-center text-sm opacity-70">
                        <span>Substack content will appear here.</span>
                    </div>
                </x-tab>

                <x-tab name="linkedin" label="Linkedin updates">
                    <div class="py-6 text-center text-sm opacity-70">
                        <span>Linkedin updates will appear here.</span>
                    </div>
                </x-tab>

                <x-tab name="twitter" label="Twitter updates">
                    <div class="py-6 text-center text-sm opacity-70">
                        <span>Twitter updates will appear here.</span>
                    </div>
                </x-tab>
            </x-tabs>
        </div>
    </div>
</x-card>
