<x-card title="{{$newsletter->subject}}" subtitle="{{$newsletter->from_email}}" separator>

    <x-form no-separator>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="VC Firm" :value="$newsletter->vc->name ?? 'N/A'" disabled />
            <x-input label="Message UID" :value="$newsletter->message_id ?? 'N/A'" disabled />


            <x-input label="Sent At" :value="$newsletter->sent_at?->format('Y-m-d H:i') ?? 'N/A'" disabled />
            <x-input label="Received At" :value="$newsletter->received_at ?? 'N/A'" disabled />
        </div>


        <div class="mt-4">
            <label class="font-semibold text-sm">Body:</label>

            <div class="mockup-window border border-base-300 w-full">
                <div class="p-3 border-t border-base-300 h-80">  {!! $newsletter->body_html ?? '<em>No content</em>' !!}</div>
            </div>

        </div>
    </x-form>

    <div class="mt-6">

        <a href="{{ route('core.newsletters.index') }}" class="btn btn-sm btn-outline">← Back to Newsletters</a>


    </div>

</x-card>
