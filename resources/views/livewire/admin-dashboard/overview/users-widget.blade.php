<x-card class="bg-base-100 shadow-lg">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-heroicon-o-users class="w-5 h-5 text-primary"/>
            <span class="text-sm font-semibold">Registered Users</span>
        </div>
    </x-slot>

    <ul class="divide-y divide-base-200 max-h-64 overflow-auto">
        @foreach ($users as $user)
            <li class="py-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $user->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email ?? 'N/A'}}</p>
                        <p class="text-xs text-gray-400">
                            Registered {{ $user->created_at  }}
                        </p>
                    </div>
                    <div>

                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</x-card>









