<div>
    <x-drawer wire:model="notifyDrawer" class="w-11/12 lg:w-1/6" right close-on-escape>


        <header class="p-4 border-b border-base-300 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-primary">Notifications</h2>
                <p class="text-sm text-base-content/60">Latest system events</p>
            </div>
            <button @click="$wire.notifyDrawer = false" class="btn btn-sm btn-ghost" aria-label="Close">
                <x-icon name="o-x-mark" class="w-5 h-5"/>
            </button>
        </header>

        <ul class="list bg-base-100 rounded-box shadow-lg">

            <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Recent Notifications</li>


            <li class="list-row">
                <div class="text-2xl font-thin opacity-30 tabular-nums">01</div>

                <div class="list-col-grow">
                    <div class="font-medium text-base-content">New VC Firm Added</div>
                    <div class="text-xs opacity-60 line-clamp-1">Sequoia Capital has been successfully added.</div>
                </div>

                <span class="text-xs opacity-50 whitespace-nowrap ml-2">2m ago</span>
            </li>


            <li class="list-row">
                <div class="text-2xl font-thin opacity-30 tabular-nums">02</div>

                <div class="list-col-grow">
                    <div class="font-medium text-base-content">Subscription Paused</div>
                    <div class="text-xs opacity-60 line-clamp-1">John Doe paused their subscription plan.</div>
                </div>

                <span class="text-xs opacity-50 whitespace-nowrap ml-2">1h ago</span>
            </li>


            <li class="list-row">
                <div class="text-2xl font-thin opacity-30 tabular-nums">03</div>

                <div class="list-col-grow">
                    <div class="font-medium text-base-content">System Health Check</div>
                    <div class="text-xs opacity-60 line-clamp-1">All systems are operational.</div>
                </div>

                <span class="text-xs opacity-50 whitespace-nowrap ml-2">Yesterday</span>
            </li>
        </ul>



    </x-drawer>

    <x-button label="Notification" icon="o-bell-alert" class="btn-ghost btn-sm" responsive
              wire:click="$toggle('notifyDrawer')"/>

</div>
