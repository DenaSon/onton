<x-card class="bg-base-100 shadow-lg">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-heroicon-o-envelope-open class="w-5 h-5 text-primary"/>
            <span class="text-sm font-semibold">Crawled Newsletters</span>
        </div>
    </x-slot>

    <ul class="divide-y divide-base-200 max-h-64 overflow-auto overflow-x-hidden">
        @foreach ($newsletters as $newsletter)
            <li class="py-3">
                <div class="flex items-center justify-between">
                    <div class="max-w-[80%]">
                        <p class="font-medium truncate" title="{{ \Illuminate\Support\Str::limit($newsletter->subject,55,'...') }}">
                            {{ $newsletter->subject ?: '(No Subject)' }}
                        </p>
                        <p class="font-thin truncate text-xs" title="{{ $newsletter->from_email }}">From: {{ $newsletter->from_email }}

                            <span class="text-primary">| VC: {{$newsletter->vc->name}}</span>

                        </p>

                        <p class="text-xs text-gray-400">Received {{ $newsletter->received_at->diffForHumans() }}</p>
                    </div>

                </div>
            </li>
        @endforeach
    </ul>
</x-card>
