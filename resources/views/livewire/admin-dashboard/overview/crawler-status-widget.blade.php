<x-card class="bg-base-100 shadow-lg">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-heroicon-o-cog class="w-5 h-5 text-primary"/>
            <span class="text-sm font-semibold">Crawler Status</span>
        </div>
    </x-slot>

    <ul class="divide-y divide-base-200 max-h-64 overflow-auto overflow-x-hidden">
        @foreach ([
            ['name' => 'TechCrunch', 'status' => 'success', 'last_run' => now()->subMinutes(10)],
            ['name' => 'The Verge', 'status' => 'running', 'last_run' => now()->subMinutes(2)],
            ['name' => 'Wired', 'status' => 'failed', 'last_run' => now()->subHours(1)],
            ['name' => 'Mashable', 'status' => 'success', 'last_run' => now()->subMinutes(25)],
        ] as $source)
            <li class="py-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $source['name'] }}</p>
                        <p class="text-xs text-gray-400">Last run {{ $source['last_run']->diffForHumans() }}</p>
                    </div>
                    <div>
                        @if ($source['status'] === 'success')
                            <x-heroicon-o-check-circle class="w-5 h-5 text-success" />
                        @elseif ($source['status'] === 'running')
                            <x-heroicon-o-arrow-path class="w-5 h-5 text-warning animate-spin" />
                        @elseif ($source['status'] === 'failed')
                            <x-heroicon-o-x-circle class="w-5 h-5 text-error" />
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</x-card>
