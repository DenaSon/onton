<x-dropdown class="dropdown dropdown-hover w-auto">
    <x-slot:trigger>
        <div class="indicator">
            <x-button icon="o-bell" class="btn-circle btn-ghost" />
            @if($notifications->count())
                <span class="indicator-item indicator-start">
                    <x-badge value="{{ $notifications->count()}}" class="badge-xs badge-warning"/>
                </span>
            @endif
        </div>
    </x-slot:trigger>

    <div class="p-2 max-w-sm w-[90vw] break-words"> {{-- ⬅ اینجا break-words اضافه شده --}}
        <h3 class="text-sm font-semibold px-2 text-base-content mb-1">Notifications</h3>

        <ul class="space-y-1 max-h-80 overflow-auto">
            @forelse ($notifications as $notification)
                <li class="bg-base-100 rounded-box px-3 py-2 shadow-sm border border-base-300 break-words">
                    <div class="flex justify-between items-start gap-2">
                        <div class="flex-1 min-w-0"> {{-- ⬅ اطمینان از wrap شدن --}}
                            <div class="text-sm font-semibold text-base-content">
                                {{ $notification->data['title'] ?? 'Notification' }}
                            </div>
                            <div class="text-xs text-base-content/70 mt-0.5">
                                {{ Str::limit($notification->data['message'] ?? '', 60) }}
                            </div>
                            @if ($notification->data['action_url'] ?? false)
                                <a href="{{ $notification->data['action_url'] }}"
                                   class="text-xs text-primary hover:underline inline-block mt-1 break-all"> {{-- ⬅ break-all برای لینک --}}
                                    {{ $notification->data['action_text'] ?? 'View' }}
                                </a>
                            @endif

                            <div class="text-[11px] text-base-content/50 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <form wire:submit.prevent="markAsRead('{{ $notification->id }}')">
                            <button type="submit"
                                    class="tooltip btn btn-xs btn-ghost text-xs text-gray-500 hover:text-primary">
                                Mark
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="px-3 py-2 text-sm text-center text-gray-400">
                    No new notifications
                </li>
            @endforelse
        </ul>
    </div>
</x-dropdown>
