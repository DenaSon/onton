<x-card class="bg-base-100 shadow-lg">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-heroicon-o-users class="w-5 h-5 text-primary"/>
            <span class="text-sm font-semibold">Latest Registered Users</span>
        </div>
    </x-slot>

    <ul class="divide-y divide-base-200 max-h-64 overflow-auto">
        @foreach (range(1, 10) as $i)
            <li class="py-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">User {{ $i }}</p>
                        <p class="text-xs text-gray-500">user{{ $i }}@example.com</p>
                        <p class="text-xs text-gray-400">
                            Registered {{ now()->subDays($i)->diffForHumans() }}
                        </p>
                    </div>
                    <div>
                        @if($i % 2 === 0)
                            <x-heroicon-o-bolt class="w-5 h-5 text-success"/>
                        @else
                            <x-heroicon-o-bolt-slash class="w-5 h-5 text-error tooltip"/>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</x-card>









