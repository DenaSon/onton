<x-card title="Newsletters" subtitle="Latest crawled newsletters" separator progress-indicator>

    @foreach($whitelists as $key => $whitelist)

        <x-list-item :item="$whitelist" wire:key="{{$whitelist->id}}">


            <x-slot:avatar>
                <x-badge value="{{$whitelist->vc->name ?? 'N/A'}}"
                         class="badge-primary badge-soft"/>
            </x-slot:avatar>


            <x-slot:value>

                {{ $whitelist->subject ?? 'N/A' }}
            </x-slot:value>

            <x-slot:sub-value>

                <span class="text-primary">{{ $whitelist->from_email ?? 'N/A' }} </span> |
                Received:{{ $whitelist->received_at->diffForHumans() }}

            </x-slot:sub-value>


            <x-slot:actions>

                <x-button spinner class="btn-sm tooltip btn-error" wire:click="deleteNewsletter({{$whitelist}})"
                          label="Delete"
                          data-tip="Delete Newsletter" wire:confirm="Delete newsletter?"/>

                <a target="_blank" href="{{ route('core.newsletter.show', ['newsletter' => $whitelist->id]) }}">
                    <x-button data-tip="Show" icon="o-eye" class="btn-xs btn-primary tooltip" spinner/>
                </a>

            </x-slot:actions>


        </x-list-item>

    @endforeach
    <div class="mt-4 flex justify-center">
        {{ $whitelists->links() }}
    </div>


</x-card>


