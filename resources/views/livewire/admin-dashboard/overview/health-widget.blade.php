<section class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-3" id="healthWidget">

    <x-card class="bg-base-100 shadow-md">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <x-heroicon-o-cpu-chip class="w-5 h-5 text-primary"/>
                <span class="text-sm font-semibold">Health & Resource Status</span>
            </div>
        </x-slot>

        <ul class="divide-y divide-base-200 text-sm">
            {{-- Laravel Version --}}
            <li class="flex items-center justify-between py-3">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-fire class="w-5 h-5 text-rose-500"/>
                    <span>Laravel</span>
                </div>
                <span class="badge badge-neutral">
                {{ $health['laravel']['version'] }}
            </span>
            </li>

            {{-- PHP Version --}}
            <li class="flex items-center justify-between py-3">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-code-bracket class="w-5 h-5 text-indigo-500"/>
                    <span>PHP</span>
                </div>
                <span class="badge badge-accent">
                {{ $health['php']['version'] }}
            </span>
            </li>

            {{-- Database --}}
            <li class="flex items-center justify-between py-3">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-table-cells class="w-5 h-5 text-blue-500"/>
                    <span>Database</span>
                </div>
                <div class="flex items-center gap-2">

                        <span
                            class="badge {{ $health['database']['status'] ? 'badge-success badge-outline badge-xs' : 'badge-error' }}">
                   <div class="inline-grid *:[grid-area:1/1]">
                                <div class="status status-success animate-ping"></div>
                                <div class="status status-success"></div>
                            </div>
            </span>


                </div>
            </li>


            {{-- Cache --}}
            <li class="flex items-center justify-between py-3">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-bolt class="w-5 h-5 text-purple-500"/>
                    <span>Cache</span>
                </div>
                <span
                    class="badge {{ $health['cache']['status'] ? 'badge-success badge-outline badge-xs' : 'badge-error' }}">
                   <div class="inline-grid *:[grid-area:1/1]">
                                <div class="status status-success animate-ping"></div>
                                <div class="status status-success"></div>
                            </div>
            </span>
            </li>


            {{-- Queue --}}
            <li class="flex items-center justify-between py-3">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-clock class="w-5 h-5 text-pink-500"/>
                    <span>Queue</span>
                </div>
                @if(isset($health['queue']['error']))
                    <span class="badge badge-error">
                    {{ $health['queue']['error'] }}
                </span>
                @else
                    <span class="badge badge-info">
                    {{ $health['queue']['connection'] }} ({{ $health['queue']['pending_jobs'] }} jobs)
                </span>
                @endif
            </li>


            {{-- Disk Usage --}}
            <li class="py-3">
                <div class="flex items-center gap-2 justify-between mb-1">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-server-stack class="w-5 h-5 text-yellow-600"/>
                        <span>Disk Usage</span>
                    </div>
                    <span class="text-xs font-semibold text-warning">
                    {{ $health['disk']['used_percent'] }}
                </span>
                </div>
                <div class="text-xs text-gray-500 flex justify-between">
                    <span>Total: {{ $health['disk']['total'] }}</span>
                    <span>Free: {{ $health['disk']['free'] }}</span>
                </div>
                <progress class="progress progress-warning w-full mt-1"
                          value="{{ rtrim($health['disk']['used_percent'], '%') }}"
                          max="100"></progress>
            </li>

            {{-- Mail --}}
            <li class="flex items-center justify-between py-3">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-envelope class="w-5 h-5 text-green-600"/>
                    <span>Mail Server</span>
                </div>
                <span class="text-xs text-gray-500">
                {{ $health['mail']['driver'] }}: {{ $health['mail']['host'] }}:{{ $health['mail']['port'] }}
            </span>
            </li>


        </ul>
    </x-card>


    {{-- Latest Activity Logs Card --}}
    <x-card class="bg-base-100 shadow-md max-w-full overflow-hidden">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <x-icon name="o-rectangle-stack" class="w-5 h-5 text-primary"/>
                <span class="text-sm font-semibold">Latest Activity Logs</span>
            </div>
        </x-slot>

        <div
            class="px-4 py-2 max-h-80 overflow-y-auto space-y-3 scrollbar-thin scrollbar-thumb-base-300 scrollbar-track-base-200">
            @forelse($activities as $activity)
                @php
                    $event = $activity->event ?? 'unknown';
                    $eventColors = [
                        'login' => 'text-green-600',
                        'logout' => 'text-yellow-600',
                        'register' => 'text-blue-600',
                    ];
                    $eventIcons = [
                        'login' => 'o-arrow-right-on-rectangle',
                        'logout' => 'o-arrow-left-on-rectangle',
                        'register' => 'o-user-plus',
                        'unknown' => 'o-question-mark-circle',
                    ];
                    $eventColor = $eventColors[$event] ?? 'text-gray-600';
                    $iconName = $eventIcons[$event] ?? $eventIcons['unknown'];
                @endphp

                <div class="flex items-start gap-3 border-b border-base-200 pb-2">
                    <x-icon :name="$iconName" class="w-5 h-5 mt-1 {{ $eventColor }}"/>
                    <div>
                        <p class="text-sm font-medium">
                            {{ ucfirst($event) }} — <span class="text-gray-700">{{ $activity->description }}</span>
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $activity->created_at->diffForHumans() }}
                        </p>
                        @if(
       !empty(data_get($activity->properties, 'ip')) ||
       !empty(data_get($activity->properties, 'platform')) ||
       !empty(data_get($activity->properties, 'Device'))
   )
                            <p class="text-[10px] text-gray-400 mt-1">
                                IP: {{ data_get($activity->properties, 'ip', 'N/A') }} |
                                Platform: {{ \Str::limit(data_get($activity->properties, 'platform', 'N/A'), 40) }} |
                                Device: {{ data_get($activity->properties, 'Device', 'N/A') }}
                            </p>
                        @endif
                    </div>

                </div>

            @empty
                <div class="text-sm text-gray-500 py-4 text-center">
                    <x-icon name="o-information-circle" class="inline w-4 h-4 mr-1"/>
                    No recent activity logs found.
                </div>
            @endforelse
        </div>
        <div class="border-t border-base-200 py-4 text-right">
            <a href="{{ route('core.activity-logs') }}" wire:navigate
               class="text-primary text-xs hover:underline hover:text-primary/80 transition duration-150 ease-in-out">
                Show More...
            </a>
        </div>

    </x-card>


</section>
