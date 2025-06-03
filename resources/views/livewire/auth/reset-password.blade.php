<form wire:submit.prevent="resetPassword" class="space-y-4">
<x-hr/>
    <x-input
        label="Email"
        type="email"
        wire:model.defer="email"
        icon="o-envelope"
        required
        readonly
    />

    <x-password
        label="New Password"
        type="password"
        wire:model.defer="password"

        required
        password-icon="o-lock-closed" password-visible-icon="o-lock-open"
        right
    />

    <x-password
        label="Confirm New Password"
        type="password"
        wire:model.defer="password_confirmation"

        required
        password-icon="o-lock-closed" password-visible-icon="o-lock-open"
        right
    />

    <div class="pt-4">
        <x-button spinner="resetPassword" label="Reset Password" type="submit" class="btn-primary w-full"/>
    </div>
</form>
