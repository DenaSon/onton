<section class="p-4 bg-base-200 min-h-screen" id="activityLogs">

    @php
        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'w-12'],
            ['key' => 'created_at', 'label' => 'Time'],
            ['key' => 'log_name', 'label' => 'Log'],
            ['key' => 'event', 'label' => 'Event'],
            ['key' => 'description', 'label' => 'Description'],
            ['key' => 'causer_type', 'label' => 'Causer'],
            ['key' => 'causer_id', 'label' => 'Causer ID', 'class' => 'w-20'],
        ];
    @endphp


    <x-card progress-indicator  title="Activity Logs" subtitle="Manage Activities" separator wire:poll.10s>

        <x-table empty-text="No Records" empty="The list is empty" wire:model="expanded" expandable :headers="$headers"
                 :rows="$logs" :sort-by="$sortBy" with-pagination>


            @scope('expansion', $log)
            <div class="">
                @include('livewire.admin-dashboard.logs._partials._log-expansion') {{-- This show Propertise of logs--}}
            </div>
            @endscope


        </x-table>

    </x-card>


</section>
