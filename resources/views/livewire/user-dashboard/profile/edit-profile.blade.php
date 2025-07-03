<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-2">
        <div>
            <h2 class="text-2xl font-semibold text-base-content">Edit Profile</h2>
            <p class="text-sm text-base-content/70">Update your personal information and change your password.</p>
        </div>
    </div>

    {{-- Profile Info --}}
    <x-card class="rounded-xl shadow-sm">
        <x-slot name="header">
            <div class="font-semibold text-base-content text-lg">Personal Information</div>
        </x-slot>

        <div class="space-y-4">
            <x-input
                label="Full Name"
                wire:model.defer="name"
                placeholder="Your name"
                icon="o-user"
                required
                autofocus
            />
        </div>
    </x-card>

    <x-card class="rounded-xl shadow-sm">
        <x-slot name="header">
            <div class="font-semibold text-base-content text-lg">Change Password</div>
        </x-slot>

        {{-- All password fields in one row (responsive) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-input
                label="Current Password"
                type="password"
                wire:model.defer="current_password"
                icon="o-key"
                placeholder="Your current password"
            />

            <x-input
                label="New Password"
                type="password"
                wire:model.defer="password"
                icon="o-lock-closed"
                placeholder="••••••••"
            />

            <x-input
                label="Confirm New Password"
                type="password"
                wire:model.defer="password_confirmation"
                icon="o-lock-closed"
                placeholder="Repeat new password"
            />
        </div>

        <div class="text-xs text-base-content/60 mt-3">
            To change your password, please enter your current password and then your new one.
        </div>
    </x-card>





    <div class="flex justify-end">
        <x-button
            label="Save Changes"
            icon="o-check-circle"
            wire:click.debounce.300ms="save"
            spinner
            class="btn-primary"
        />
    </div>
</div>
