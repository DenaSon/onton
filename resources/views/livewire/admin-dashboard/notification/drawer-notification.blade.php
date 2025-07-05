<div>
    <x-drawer wire:model="notifyDrawer" class="w-11/12 lg:w-1/6" right close-on-escape>


        <header class="p-4 border-b border-base-300 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-primary">Notifications</h2>
                <p class="text-sm text-base-content/60">Latest system events</p>
            </div>
            <button  @click="$wire.notifyDrawer = false" class="btn btn-sm btn-ghost" aria-label="Close">
                <x-icon name="o-x-mark" class="w-5 h-5"/>

            </button>
        </header>

        <ul class="list bg-base-100 rounded-box shadow-lg">

            <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Recent Notifications</li>

            @forelse($notifications as $notification)
                <li class="p-4 hover:bg-base-200 transition-all">
                    <div class="flex flex-col gap-1">
                        <div class="text-sm font-semibold text-base-content">
                            {{ $notification->data['title'] ?? 'Untitled' }}
                        </div>
                        <div class="text-xs text-base-content/70" title="{{ Str::limit($notification->data['message'] ?? '-', 250) }}">
                            {{ Str::limit($notification->data['message'] ?? '-', 60) }}
                        </div>
                        <div class="text-[10px] text-base-content/50 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                </li>
            @empty
                <li class="p-4 text-sm text-base-content/70">No notifications found.</li>
            @endforelse

        </ul>





    </x-drawer>
    <x-button
        badge="{{count($notifications) ?? 0}}" badgeClasses="badge badge-soft badge-sm absolute top-0 right-0 translate-x-1/2 -translate-y-1/2"
        label="Notification"
        icon="o-bell-alert"
        class="btn-ghost btn-sm relative"
        responsive
        wire:click="$toggle('notifyDrawer')"
    />



</div>
