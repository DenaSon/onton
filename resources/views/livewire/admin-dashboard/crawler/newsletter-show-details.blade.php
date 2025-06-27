<x-card title="{{$newsletter->subject}}" subtitle="{{$newsletter->from_email}}" separator>

    <x-form no-separator>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="VC Firm" :value="$newsletter->vc->name ?? 'N/A'" disabled />
            <x-input label="Message UID" :value="$newsletter->message_id ?? 'N/A'" disabled />


            <x-input label="Sent At" :value="$newsletter->sent_at?->format('Y-m-d H:i') ?? 'N/A'" disabled />
            <x-input label="Received At" :value="$newsletter->received_at ?? 'N/A'" disabled />
        </div>


        <div class="mt-6">
            <label class="font-semibold text-sm mb-2 block">Body:</label>

            <iframe
                class="w-full border border-base-300 rounded h-[40rem] bg-white"
                src="{{ route('core.newsletter.html', ['id' => $newsletter->id]) }}"
                sandbox
            ></iframe>



        </div>

    </x-form>



    <div class="mt-6">

        <a href="{{ route('core.newsletters.index') }}" class="btn btn-sm btn-outline">← Back to Newsletters</a>


    </div>

</x-card>
