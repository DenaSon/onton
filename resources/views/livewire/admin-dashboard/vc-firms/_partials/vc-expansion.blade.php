<div class="overflow-x-auto">
    <table class="table table-fixed w-full text-sm">
        <tbody>
        <tr>
            <th class="whitespace-nowrap">Newsletters</th>
            <td>{{ $vcFirm->newsletters_count }}</td>
        </tr>

        <tr>
            <th>Website</th>
            <td>
                @if ($vcFirm->website)
                    <a href="{{ $vcFirm->website }}" target="_blank" class="link link-primary break-all">
                        {{ $vcFirm->website ?? 'N/A' }}
                    </a>
                @else
                    N/A
                @endif
            </td>
        </tr>


        <tr>
            <th>Vertical Tags</th>
            <td>
                @foreach($vcFirm->tags->where('type', 'vertical') as $tag)
                    <span class="badge badge-sm badge-outline mr-1">{{ $tag->name }}</span>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Stage Tags</th>
            <td>
                @foreach($vcFirm->tags->where('type', 'stage') as $tag)
                    <span class="badge badge-sm badge-outline mr-1">{{ $tag->name }}</span>
                @endforeach
            </td>
        </tr>

        <tr>
            <th>Whitelist Emails</th>
            <td class="flex flex-wrap gap-1">
                @forelse($vcFirm->whitelists as $email)
                    <span class="badge badge-outline badge-sm">{{ $email->email }}</span>
                @empty
                    <span class="text-gray-400">No whitelisted emails</span>
                @endforelse
            </td>
        </tr>


        <tr>
            <th>logo</th>
            <td>
                @if($vcFirm->logo_url)
                    <a href="{{ asset('storage/' . $vcFirm->logo_url) }}" target="_blank">
                        <img width="14" height="14"
                            src="{{ asset('storage/' . $vcFirm->logo_url) }}"
                            alt="Logo Preview"
                            class="w-14 h-14 rounded-2xl"
                        />
                    </a>
                @endif
            </td>
        </tr>


        </tbody>
    </table>
</div>
