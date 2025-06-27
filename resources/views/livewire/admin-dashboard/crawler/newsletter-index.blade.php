<x-card title="Newsletters Hub" subtitle="Latest crawled newsletters" separator progress-indicator>

    @foreach($newsletters as $key => $newsletter)

        <x-list-item :item="$newsletter" wire:key="{{$newsletter->id}}">


            <x-slot:avatar>
                <x-badge value="{{$newsletter->vc->name ?? 'N/A'}}"
                         class="badge-primary badge-soft"/>
            </x-slot:avatar>


            <x-slot:value>

                {{ $newsletter->subject ?? 'N/A' }}
            </x-slot:value>

            <x-slot:sub-value>

                <span class="text-primary">{{ $newsletter->from_email ?? 'N/A' }} </span>  | Received:{{ $newsletter->received_at->diffForHumans() }}

            </x-slot:sub-value>


            <x-slot:actions>
                <a target="_blank" href="{{ route('core.newsletter.show', ['newsletter' => $newsletter->id]) }}">
                    <x-button data-tip="Show" icon="o-eye" class="btn-xs btn-primary tooltip" spinner />
                </a>

            </x-slot:actions>


        </x-list-item>

    @endforeach
    <div class="mt-4 flex justify-center">
        {{ $newsletters->links() }}
    </div>


</x-card>


