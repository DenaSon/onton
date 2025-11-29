<x-card class="mt-6 bg-base-100 shadow-xl rounded-xl">
    <x-slot name="title">
        <div class="flex items-center gap-1">
            <x-heroicon-o-chart-bar class="w-5 h-5 text-primary"/>
            <span class="text-sm font-semibold">Activity</span>
        </div>
    </x-slot>

    <div class="px-1 py-1">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center sm:text-left">

            {{-- Existing stats --}}
            <x-stat
                title="Newsletters Today"
                :value="$newslettersToday"
                icon="o-envelope"
                color="text-accent"
                tooltip="Total newsletters fetched today"
                class="mx-auto sm:mx-0"
            />

            <x-stat
                title="Total VCs"
                :value="$totalVCs"
                icon="o-inbox-stack"
                color="text-primary"
                tooltip="Total number of VC firms in the system"
                class="mx-auto sm:mx-0"
            />

            <x-stat
                title="Followed VCs"
                :value="$followedVCs"
                icon="o-heart"
                color="text-secondary"
                tooltip="Number of VCs you are following"
                class="mx-auto sm:mx-0"
            />

            {{-- New stats: last week, for followed VCs --}}
            <x-stat
                title="My Email Newsletters"
                :value="$emailNewslettersLastWeek"
                icon="o-envelope"
                color="text-primary"
                tooltip="Email newsletters from your followed VCs in the last 7 days"
                class="mx-auto sm:mx-0"
            />

            <x-stat
                title="My Substack Newsletters"
                :value="$substackNewslettersLastWeek"
                icon="o-newspaper"
                color="text-primary"
                tooltip="Substack newsletters from your followed VCs in the last 7 days"
                class="mx-auto sm:mx-0"
            />

            <x-stat
                title="My Medium Updates"
                :value="$mediumUpdatesLastWeek"
                icon="o-document-text"
                color="text-primary"
                tooltip="Medium updates from your followed VCs in the last 7 days"
                class="mx-auto sm:mx-0"
            />

        </div>

        <div class="mt-2 text-center sm:text-right">
            <a href="{{ route('vc.directory') }}" class="text-xs text-secondary hover:underline font-semibold">
                Explore more VC firms →
            </a>
        </div>
    </div>
</x-card>
