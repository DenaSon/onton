<x-card title="Newsletter Delivery" subtitle="Manage how often you receive newsletters" shadow separator progress-indicator>

    <div class="space-y-4">

        <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-200">
            <x-icon name="o-envelope" class="w-5 h-5 text-indigo-600" />
            <span class="font-medium">Delivery Frequency</span>
        </div>

        <x-group
            label="Choose how often you’d like to receive emails"
            :options="[
                ['value' => 'daily', 'label' => 'Daily'],
                ['value' => 'weekly', 'label' => 'Weekly'],

            ]"
            wire:model="frequency"
            option-value="value"
            option-label="label"
            class="[&:checked]:!btn-primary btn-sm"
        />

        @if ($lastSentAt)
            <div class="text-sm text-gray-500 dark:text-gray-400 pt-2">
                Last newsletter sent on:
                <span class="font-medium text-gray-800 dark:text-gray-200">
                    {{ $lastSentAt->format('F j, Y \a\t H:i') }}
                </span>
            </div>
        @endif

        <div class="pt-6">
            <x-button label="Save Settings" wire:click="save" class="btn-primary" />
        </div>

    </div>

</x-card>
